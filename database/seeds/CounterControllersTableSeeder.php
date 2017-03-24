<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CounterControllersTableSeeder extends Seeder
{
	use SeederHelpers;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$start = SeederConfig::START_DATE();		// Fecha inicio
		$end = SeederConfig::END_DATE();			// Fecha fin
		$batchSize = SeederConfig::BATCH_SIZE;		// Registros a insertar por transaccion
		$fields = config('countersfields');			// Array con los campos por vendor y tecnología
		$technologies = SeederConfig::TECHNOLOGIES;	// Tecnologias a procesar
		$valuesBy = SeederConfig::COUNTER_VALUES;	// Valores por defecto para asignar a los contadores

		foreach ($technologies as $tech) {
			$controllers = $this->getControllers($tech);

			$now = $start->copy();

			// Recorro las fechas+horas
			while ($now <= $end)
			{
				$data_eri = array();
				$data_hua = array();
				$counter = $batchSize;

				// Recorro los controladores de 2G y 3G
				foreach($controllers as $controller)
				{
					$data = $this->makeEntry(
						$controller->id,
						$now->toDateTimeString(),
						count($fields[$controller->vendor][$tech]),
						$valuesBy[$controller->vendor][$tech]
					);

					if($controller->vendor == 'eri') {
						$data_eri[] = $data;
					}
					else {
						$data_hua[] = $data;
					}

					$counter--;

					if($counter == 0 && $tech != '2g') {
						DB::table('eri.counters_' . $tech . '_controller_rop')->insert($data_eri);
						DB::table('hua.counters_' . $tech . '_controller_rop')->insert($data_hua);
						$data_eri = array();
						$data_hua = array();
						$counter = $batchSize;
					}

					if($now->minute == '00') {
						if($now->hour == '12') {
							DB::table($controller->vendor  . '.counters_' . $tech . '_controller_day')->insert($data);
						}

						DB::table($controller->vendor . '.counters_' . $tech . '_controller_hour')->insert($data);
					}

				}

				if($counter > 0 && $counter < $batchSize && $tech != '2g') {
					DB::table('eri.counters_' . $tech . '_controller_rop')->insert($data_eri);
					DB::table('hua.counters_' . $tech . '_controller_rop')->insert($data_hua);
					$data_eri = array();
					$data_hua = array();
				}

				$now->addMinutes(15);
			}
		}

    }

	private function getControllers($tech) {
		return DB::table('controllers')
			->where('tech', $tech)
			->select('id', 'vendor')
			->get();
	}
}
