<?php

namespace App\RTM\Kpi;

use Illuminate\Support\Facades\DB;

class KpiRepository
{

	/**
	 * Filtro los kpis que usen el parcial. Uso Regex para evitarfiltrar kpis
	 * que usen parciales de orden mayor de "p1" -> "p1", "p10", "p101".
	 * En PHP el regex es "(p10\b)", en Postgresql "(p100\M)"
	 * 
	 * @return [type] [description]
	 */
	public function dependenciesBy($partial)
	{
		return DB::select(
			DB::raw(
				"SELECT name FROM public.kpis WHERE equation ~ '({$partial})\M'"
			)
		);
	}


	public function getEquations($by, array $vendors, array $technologies)
	{
		$aggregate = ($by == 'controller' || $by == 'province' || $by == 'zone')
			? true
			: false;

		$equations['kpis'] = $this->kpis(
			count($vendors) > 1 ? null : $vendors,
			count($technologies) > 1 ? null : $technologies,
			$aggregate
		);

		$equations['partials'] = $this->partials(
			$vendors,
			$technologies
		);

		return $this->removeKpiWithPartialMissing($equations);
	}


	/**
	 * Elimino los kpis con parciales no disponibles.
	 * 
	 * @param  $equations
	 * @return array
	 */
	private function removeKpiWithPartialMissing($equations)
	{
		$kpis = array();

		// Creo un string con los parciales disponibles
		$availablePartials = implode('|', array_pluck($equations['partials'], 'name'));

		// Recorro los kpis
		foreach ($equations['kpis'] as $kpi) {

			// Busco los parciales usados en el kpi actual
			preg_match_all ("/([p]\d+)/", $kpi->equation, $matches);

			// Filtro los parciales del kpi encontrados con los
			// disponibles, solo me quedo con los que no encuentre
			$partialsNotFound = array_filter($matches[0], function($partial) use ($availablePartials) {
				return stripos($availablePartials, $partial) === false;
			});

			// Si el array tiene datos, es que el kpi hace uso de
			// parciales no disponibles, por lo que se descarta
			if( empty($partialsNotFound) ) {
				$kpis[] = $kpi;
			}
		}

		$equations['kpis'] = $kpis;

		return $equations;
	}



	private function kpis(array $vendors = null, array $technologies = null, $aggregate = false)
	{
		$data = DB::table('kpis')
			->where('type', '<>', 'prt');

		$data = $this->filter($data, 'vendor', $vendors);
		$data = $this->filter($data, 'tech', $technologies);

		if($aggregate) {
			return $data->select(
				'name',
				'equation',
				'type',
				'tech',
				'vendor',
				'symbol_red',
				'symbol_yellow',
				'threshold_aggregate_red as threshold_red',
				'threshold_aggregate_yellow as threshold_yellow'
			)
			->get()
			->toArray();
		}

		return $data->select(
				'name',
				'equation',
				'type',
				'tech',
				'vendor',
				'symbol_red',
				'symbol_yellow',
				'threshold_red',
				'threshold_yellow'
			)
			->get()
			->toArray();
	}


	private function filter($data, $field, $value)
	{
		if($value != null) {
			return $data->whereIn($field, $value);
		}

		return $data->where($field, null);
	}


	private function partials(array $vendors, array $technologies)
	{
		return DB::table('kpis')
			->where('type', '=', 'prt')
			->whereIn('vendor', $vendors)
			->whereIn('tech', $technologies)
			->select(DB::raw("concat('p', id) as name"), 'equation', 'tech', 'vendor')
			->get()->toArray();
	}
}