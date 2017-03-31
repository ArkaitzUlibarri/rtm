<?php

namespace App\Console\Commands;

use App\RTM\Filter\FilterRepository;
use App\RTM\Kpi\KpiRepository;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ProcessAbsoluteKpis extends Command
{
	/**
	 * Instancia del repositorio de KPIs.
	 *
	 * @var KpiRepository
	 */
	private $kpiRepository;

	private $filterRepository;


	/**
	 * Controladores agrupados por vendor y tecnologia. 
	 * 
	 * @var array
	 */
	private $controllers = [];

	/**
	 * KPIs absolutos agrupados por vendor y tecnologia.
	 * 
	 * @var array
	 */
	private $kpis = [];

	/**
	 * Parciales agrupados por vendor y tecnologia.
	 * 
	 * @var array
	 */
	private $partials = [];

	/**
	 * Numero de muestras maximo (N) a filtrar por vendor y tecnologia.
	 * 
	 * @var array
	 */
	private $maxSamples = [];

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'kpi:absolute {datetime}'; //'command:name';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Process de absolute kpis.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(
		KpiRepository $kpiRepository,
		FilterRepository $filterRepository)
	{
		parent::__construct();

		$this->kpiRepository = $kpiRepository;
		$this->filterRepository = $filterRepository;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		if(! $this->validateDate($this->argument('datetime'))) {
			return;
		}

		// Creo una instancia de Carbon para la fecha de entrada
		$endDate = Carbon::createFromFormat('Y-m-d H:i', $this->argument('datetime'));
		//Carbon::parse('2012-9-5 23:26:11.123789');

		// Filtro los kpis absolutos y los agrupo por vendor y tecnologia.
		$this->getKpis();

		// Filtro los parciales y los agrupo por vendor y tecnologia.
		$this->getPartials();

		// Obtengo los controladores agrupos por vendor y tecnologia.
		$this->getControllers();

		// $this->controllers = ["eri" => ["4g" => ["eri.counters_4g_province_rop" => [6 => 6,]]]];

		$alarms = array();

		foreach (config('filter.vendor') as $vendor) {
			foreach (config('filter.technologies') as $tech) {
		
				if(! $this->canProcess($vendor, $tech, $endDate)) {
					continue;
				}			

				$startDate = $tech == '2g'
					? $endDate->copy()->subHours($this->maxSamples[$vendor][$tech]-1)
					: $endDate->copy()->subMinute(($this->maxSamples[$vendor][$tech]-1) * 15);

				/*
				var_dump(
					$vendor . ' - ' . $tech . ' - ' . $this->maxSamples[$vendor][$tech] . ' --> ' . $startDate->toDateTimeString() . ' -> ' . $endDate->toDateTimeString()
				);
				*/
			
				$data = $this->filterRepository->fetchKpi([
					"start_date" => $startDate,
					"end_date" => $endDate,
					"aggregate" => false,
					"items" => $this->controllers[$vendor][$tech],
					"equations" => [
						"kpis" => $this->kpis[$vendor][$tech],
						"partials" => isset($this->partials[$vendor][$tech]) ? $this->partials[$vendor][$tech] : []
					]
				]);

				$currentAlarms = $this->getAlarmsFrom(
					$this->kpis[$vendor][$tech],
					$data
				);

				if(count($currentAlarms) > 0) {
					$alarms = array_merge($currentAlarms, $alarms);
				}
			} 
		}
		
		dd($alarms);
	}




	private function getAlarmsFrom($kpis, $entries)
	{
		$array = array();

		foreach ($kpis as $kpi) {

			foreach ($entries as $entry) {

				$kpiName = $kpi->name;

				// var_dump($kpiName . " -> " . $entry->$kpiName . " -> " . $kpi->symbol . " -> " . $kpi->threshold);

				if( ! $this->kpiSuccess(
					$entry->$kpiName,
					$kpi->symbol,
					$kpi->threshold)) {

					if( isset($array[$entry->item][$kpi->id]) ) {
						$array[$entry->item][$kpi->id]['failures'] += 1;
						$array[$entry->item][$kpi->id]['value'][] = $entry->$kpiName;
					}
					else {
						$array[$entry->item][$kpi->id] = [
							'type'               => 'absolute',
							'vendor'             => $kpi->vendor,
							'tech'               => $kpi->tech,
							'controller_id'      => $entry->item,
							'cell_id'            => null,
							'kpi_id'             => $kpi->id,
							'value'              => [$entry->$kpiName],
							'relative_threshold' => null,
							'threshold'          => $kpi->threshold,
							'samples'            => $kpi->samples,
							'failures'           => 1
						];
					}
				}
			}

			$alarms = array();

			foreach ($array as $item => $itemsByKpis) {
				foreach ($itemsByKpis as $kpi => $item) {
					if($item['failures'] >= $item['samples']) {
						$item['value'] = $item['value'][$item['samples']-1];
						$alarms[] = $item;
					}
				}
			}
		}

		return $alarms;
	}


	/**
	 * Compruebo si el kpi cumple con el threshold. La expresion indica
	 * cuando un kpi no cumpliria con la referencia por lo que hay que
	 * hay que devolver el inverso del resultado.
	 *
	 * 95 == 95 -> NOK
	 * 50 == 95 -> OK
	 * 95 != 95 -> OK
	 * 50 != 95 -> NOK
	 * 98 <  95 -> OK
	 * 95 <  95 -> OK
	 * 90 <  95 -> NOK
	 * 98 >  95 -> NOK
	 * 95 >  95 -> OK
	 * 90 >  95 -> OK
	 * 98 <= 95 -> OK
	 * 95 <= 95 -> NOK
	 * 90 <= 95 -> NOK
	 * 98 >= 95 -> NOK
	 * 95 >= 95 -> NOK
	 * 90 >= 95 -> OK
	 * 
	 * @param  $kpi
	 * @param  $symbol
	 * @param  $threshold
	 * @return bool
	 */
	private function kpiSuccess($kpi, $symbol, $threshold)
	{
		if ($symbol == '==') {
			return ! ($kpi == $threshold);
		}
		
		if ($symbol == '!=') {
			return ! ($kpi != $threshold);
		}

		if ($symbol == '<') {
			return ! ($kpi < $threshold);
		}

		if ($symbol == '>') {
			return ! ($kpi > $threshold);
		}

		if ($symbol == '<=') {
			return ! ($kpi <= $threshold);
		}

		if ($symbol == '>=') {
			return ! ($kpi >= $threshold);
		}

		return false;
	}


	/**
	 * Devuelvo un array con los ids de los controladores por vendor y tecnologia.
	 * 
	 * @return array
	 */
	private function getControllers()
	{
		$response = DB::table('controllers')
			->select('id', 'vendor', 'tech')
			->get()
			->toArray();

		foreach ($response as $controller) {
			$table = $controller->tech == '2g'
				? "{$controller->vendor}.counters_{$controller->tech}_controller_hour"
				: "{$controller->vendor}.counters_{$controller->tech}_controller_rop";

			$this->controllers[$controller->vendor][$controller->tech][$table][$controller->id] = $controller->id;
		}

		$response = DB::table('provinces')
			->select('id')
			->get()
			->toArray();

		foreach ($response as $province) {
			$this->controllers['eri']['4g']['eri.counters_4g_province_rop'][$province->id] = $province->id;
			$this->controllers['hua']['4g']['hua.counters_4g_province_rop'][$province->id] = $province->id;
		}
	}

	/**
	 * Filtro los kpis absolutos, los agrupo por vendor y tecnologia y
	 * determino el tamaño maximo de muestras por vendor y tecnologia.
	 * 
	 * @return array
	 */
	private function getKpis()
	{
		//$fields = ['id', 'name', 'symbol', threshold', 'samples', 'equation'];

		$this->kpis = [];

		$absoluteKpis = $this->kpiRepository->absoluteKpis();

		foreach ($absoluteKpis as $kpi) {

			$this->kpis[$kpi->vendor][$kpi->tech][] = $kpi;
			//$this->kpis[$kpi->vendor][$kpi->tech][] = $this->makeObjectFrom($kpi, $fields);

			$this->updateMaxSamples(
				$kpi->vendor,
				$kpi->tech,
				$kpi->samples
			);
		}
	}

	/**
	 * Obtengo los parciales de la base de datos, los filtro para quedarme
	 * solo con los usados y los agrupo por vendor y tecnologia.
	 * 
	 * @return array
	 */
	private function getPartials()
	{
		$partials = $this->kpiRepository->partials(
			config('filter.vendor'),
			config('filter.technologies')
		);

		$availablePartials = $this->partialsArrayFrom(
			$this->kpis
		);

		foreach ($partials as $partial) {
			if(in_array($partial->name, $availablePartials)) {
				$this->partials[$partial->vendor][$partial->tech][] = $partial;
			}		
		}
	}

	/**
	 * Extaigo los parciales usados de las equaciones de kpis absolutos.
	 * 
	 * @param  $kpis
	 */
	private function partialsArrayFrom($kpis)
	{
		$availablePartials = array();

		foreach ($kpis as $vendor => $kpiByTech) {
			foreach ($kpiByTech as $tech => $kpis) {
				foreach ($kpis as $kpi) {
					preg_match_all ("/([p]\d+)/", $kpi->equation, $matches);
					$availablePartials = array_merge($availablePartials, $matches[0]);
				}
			}
		}

		return array_unique($availablePartials);
	}

	/**
	 * Actualizo el array con los numeros de muestras maximos por
	 * vendor y tecnologia.
	 * 
	 * @param  $vendor
	 * @param  $tech
	 * @param  $sampleSize
	 */
	private function updateMaxSamples($vendor, $tech, $sampleSize)
	{
		if(isset($this->maxSamples[$vendor][$tech])) {
			if($sampleSize > $this->maxSamples[$vendor][$tech]) {
				$this->maxSamples[$vendor][$tech] = $sampleSize;
			}
		} else {
			$this->maxSamples[$vendor][$tech] = $sampleSize;
		}
	}

	/**
	 * Compruebo si puedo procesar los absolutos del vendor y tecnologia
	 * actual. Si no se procesan puede ser por no tener controladores o kpis
	 * con esa convinacion, o por ser un ROP no valido para 2G.
	 * 
	 * @param  $vendor
	 * @param  $tech
	 * @param  $endDate
	 * @return bool
	 */
	private function canProcess($vendor, $tech, $endDate)
	{
		if( ! isset($this->controllers[$vendor][$tech]) ) {
			return false;
		}

		if( ! isset($this->kpis[$vendor]) ) {
			return false;
		}

		if ( ! isset($this->kpis[$vendor][$tech]) ) {
			return false;
		}

		if ( $tech == '2g' && $endDate->minute != 0 ) {
			return false;
		}

		return true;
	}

	/**
	 * Creo un objecto stdClass con los campos deseados.
	 * 
	 * @param  $item
	 * @param  $fields
	 * @return stdClass
	 */
	private function makeObjectFrom($item, $fields)
	{
		$object = new \stdClass();

		foreach ($fields as $field) {
			$object->$field = $item->$field;
		}

		return $object;
	}

	/**
	 * Valido la fecha y hora de entrada.
	 * 
	 * @param  $date
	 * @param  $format
	 * @return bool
	 */
	private function validateDate($date, $format= 'Y-m-d H:i')
	{
		return $date == date($format, strtotime($date));
	}
}