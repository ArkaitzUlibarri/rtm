<?php

namespace App\RTM\Filter;

use App\RTM\Cell\Cell;
use App\RTM\Controller\Controller;
use App\RTM\Filter\FilterOutput;
use App\RTM\Kpi\KpiRepository;
use App\RTM\Node\Node;
use App\RTM\Province\Province;

class FilterService
{
	private $filterRepository;
	private $filterOutput;
	private $kpiRepository;

	public function __construct(
		FilterRepository $filterRepository,
		FilterOutput $filterOutput,
		KpiRepository $kpiRepository ) 
	{
		$this->filterRepository = $filterRepository;
		$this->filterOutput = $filterOutput;
		$this->kpiRepository = $kpiRepository;
	}


	public function process(array $data)
	{
		if ( ($items = $this->fetchItems($data)) == [] ) {
			return "Could not find any item.";
		}

		$data = $this->orderItemsByTable($items, $data);

		// Filtro los kpis y parciales necesarios para la consulta.
		$data['equations'] = $this->kpiRepository->getEquations(
			$data['by'],
			$data['groupBy']['vendor'],
			$data['groupBy']['technology']
		);

		// Compruebo si puedo continuar con el filtrado.
		if(($message = $this->canProcess($data)) != '') {
			return $message;
		}

		// Filtro los kpis en la base de datos.
		$data['response'] = $this->filterRepository->fetchKpi($data);

		// Doy formato y devuelvo el resultado.
		return $this->filterOutput->format($data);
	}


	private function canProcess($data)
	{
		$by = $data['by'];
		$vendors = $data['groupBy']['vendor'];
		$technologies = $data['groupBy']['technology'];
		$aggregate = $data['aggregate'];
		$kpis = $data['equations']['kpis'];
		$partials = $data['equations']['partials'];

		if(isset($data['vendor']) && isset($data['tech'])) {
			if($data['vendor'] == 'aggregate' && $data['tech'] == 'aggregate') {
				return "Cannot process aggregate by vendor and technology at the same time.";
			}
		}

		if((count($vendors) > 1 || count($technologies) > 1 ) &&
			($by != 'cell'  && $by != 'node'  && $by != 'province') ) {
			return "Cannot process aggregate with '{$by}' filter.";
		}

		if(count($vendors) > 1 && count($technologies) > 1) {
			return "Cannot process dual and multiple vendor together.";
		}

		if(count($kpis) == 0) {
			return 'The are no KPIs available for current filter!';
		}

		if(count($partials) == 0 && $aggregate) {
			return 'The are no partials available for current aggregate filter!';
		}

		return;
	}


	/**
	 * 
	 */
	private function orderItemsByTable($items, $data)
	{
		$zoneAggregate = array_key_exists('zone_aggregate', $data) ? $data['zone_aggregate'] : null;

		foreach ($items as $item) {
			// Complete "groupBy" field
			$data['groupBy']['vendor'][$item->vendor] = $item->vendor;
			$data['groupBy']['technology'][$item->tech] = $item->tech;
		}

		// We don't have counters by "rop" with 2G technology, we change the resolution to "hour".
		if($data['resolution'] == 'rop' && array_key_exists('2g', $data['groupBy']['technology'])) {
			$data['resolution'] = 'hour';
		}

		$data['aggregate'] = count($data['groupBy']['vendor']) > 1 || count($data['groupBy']['technology']) > 1
			? true
			: false;

		foreach ($items as $item) {
			
			// Get the table to search the item.
			$table = "{$item->vendor}.counters_{$item->tech}";

			$table .= $zoneAggregate != null ? '_' . $zoneAggregate : config('filter.by')[$data['by']]['table'];


			$table .= '_' . $data['resolution'];

			// Add the item to the current table.
			$data['items'][$table][$item->id] =  $item;

			// Remove unnecessary fields.
			unset($data['items'][$table][$item->id]->vendor);
			unset($data['items'][$table][$item->id]->tech);
			unset($data['items'][$table][$item->id]->id);
		}

		return $data;
	}


	/**
	 * Fetch items from database.
	 * 
	 * @param  array
	 * @return array
	 */
	private function fetchItems(array $data)
	{
		if($data['by'] == 'cell') {
			return Cell::find($data['values']);
		}

		if($data['by'] == 'node') {
			return Node::findCells($data['values'], $data['tech']);
		}

		if($data['by'] == 'controller_cell') {
			return Controller::findCells($data['values']);
		}

		if($data['by'] == 'controller') {
			return Controller::find($data['values']);
		}

		if($data['by'] == 'province') {
			return Province::find($data['values'], $data['vendor'], $data['tech']);
		}

		if($data['by'] == 'zone') {
			if($data['zone_aggregate'] == 'controller') {
				return Controller::findByZone($data['zone'], $data['vendor'], $data['tech']);
			}
			else if($data['zone_aggregate'] == 'province') {
				return Province::findByZone($data['zone'], $data['vendor'], $data['tech']);
			}	
		}

		return [];
	}


	/**
	 * Get available vendors.
	 * 
	 * @param  array
	 * @return array

	private function groupByVendors($array)
	{
		$vendors = array();

		foreach ($array as $key => $value) {
			$vendor = explode('.', $key)[0];
			if(! array_key_exists($vendor, $vendors)) {
				$vendors[$vendor] = $vendor;
			}
		}

		return $vendors;
	}
	 */

	/**
	 * Get available technologies.
	 * 
	 * @param  array
	 * @return array

	private function groupByTech($array)
	{
		$technologies = array();

		foreach ($array as $key => $value) {
			$tech = explode('_', $key)[1];
			if(! array_key_exists($tech, $technologies)) {
				$technologies[$tech] = $tech;
			}
		}

		return $technologies;
	}
	 */
}