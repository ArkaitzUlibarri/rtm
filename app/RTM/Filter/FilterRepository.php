<?php

namespace App\RTM\Filter;

use Illuminate\Support\Facades\DB;

class FilterRepository
{
	/**
	 * Devuelve los kpis.
	 * 
	 * @param  array  $data
	 * @return array
	 */
	public function fetchKpi(array $data)
	{
		$query = $this->getQuery($data);

		return DB::select(
			DB::raw($query)
		);
	}


	/**
	 * Devuelve la query de filtrado en funcion de lo que queramos filtrar. 
	 * 
	 * @param  array  $data
	 * @return string
	 */
	private function getQuery(array $data)
	{
		if($data['aggregate'])
		{
			// Al ser agregado tenemos que filtrar en multiples tablas a la vez.
			return $this->makeAggregateQuery(
				$data['by'],
				$data['items'],
				$data['equations'],
				$data['resolution'],
				$data['start_date'],
				$data['end_date']
			);
		}

		// No es un agregado, por lo que solo hay una tabla en la que mirar.
		$table = implode(', ', array_keys($data['items']));
		$ids = implode(', ', array_keys($data['items'][$table]));

		return $this->makeQuery(
			$table,
			$data['equations'],
			$ids,
			$data['start_date'],
			$data['end_date']
		);
	}


	/**
	 * Creo la query para filtrar una unica tabla.
	 * 
	 * @param  $table
	 * @param  $equations
	 * @param  $ids
	 * @param  $startDate
	 * @param  $endDate
	 * @return array
	 */
	private function makeQuery($table, $equations, $ids, $startDate, $endDate)
	{
		$kpis = $this->formatString($equations['kpis']);
		$partials = $this->formatString($equations['partials']);
		$fields = $this->getFields($this->vendorFrom($table), $this->techFrom($table));

		return "SELECT created_at, item_id as item, {$kpis} FROM (SELECT created_at, item_id, {$fields}, {$partials} FROM {$table} WHERE item_id IN ({$ids}) AND created_at >= '{$startDate}' AND created_at <= '{$endDate}' ORDER BY created_at DESC, item_id ASC) as tp";
	}


	/**
	 * Crea la query para filtrar en multiples tablas. Usado
	 * cuando queremos calcular agregados duales o por vendor.
	 *
	 * SELECT t.created_at, (p1+p2) as dual1, (p1+p3) as dual2, ... FROM
	 * (
	 * 	SELECT ta1.created_at, (ta1.c1+ta1.c2) as p1, (ta1.c1+ta1.c2) as p2, (ta2.c1+ta2.c2) as p3, ... FROM
	 * 	(
	 * 		SELECT created_at, SUM(c1) as c1, SUM(c2) as c2, SUM(c3) as c3, ... FROM eri.counters_3g_hour
	 * 		WHERE item_id IN (42, 43) AND created_at >= '2017-03-06 12:00' AND created_at <= '2017-03-06 16:00'
	 * 		GROUP BY created_at
	 * 	) as ta1
	 * 	INNER JOIN 
	 * 	(
	 * 		SELECT created_at, SUM(c1) as c1, SUM(c2) as c2, SUM(c3) as c3, ... FROM eri.counters_2g_hour
	 * 		WHERE item_id IN (1, 2) AND created_at >= '2017-03-06 12:00' AND created_at <= '2017-03-06 16:00'
	 * 		GROUP BY created_at
	 * 	) as ta2
	 * 	ON ta1.created_at=ta2.created_at
	 * 	...
	 * ) as t
	 *
	 */
	private function makeAggregateQuery($by, $items, $equations, $resolution, $startDate, $endDate)
	{
		$aliasIdx = 1;
		$partialString = '';
		$kpis = $this->formatString($equations['kpis']);
		
		$query = $by == 'province'
			? "SELECT t.created_at, t.item_id as item, {$kpis} FROM (SELECT t1.created_at, t1.item_id, PARTIAL_STRING FROM "
			: "SELECT t.created_at, {$kpis} FROM (SELECT t1.created_at, PARTIAL_STRING FROM ";

		foreach ($items as $table => $value) {

			$vendor = $this->vendorFrom($table);
			$tech = $this->techFrom($table);

			$partials = array_filter($equations['partials'], function($equation) use($vendor, $tech) {
				return $equation->vendor == $vendor && $equation->tech == $tech;
			});

			$partialString .= $this->formatString($partials, "t{$aliasIdx}") . ',';
			$fields = $this->getFields($vendor, $tech, true);
			$ids = implode(', ', array_keys($value));

			if($by == 'province') {
				$query .= $aliasIdx >= 2 ? "INNER JOIN " : '';
				$query .= "(SELECT created_at, item_id, {$fields} ";
				$query .= "FROM {$table} ";
				$query .= "WHERE item_id IN ({$ids}) AND created_at >= '{$startDate}' AND created_at <= '{$endDate}' ";
				$query .= "GROUP BY created_at, item_id) as t{$aliasIdx} ";
				$query .= $aliasIdx >= 2 ? "ON t1.created_at=t{$aliasIdx}.created_at AND t1.item_id=t{$aliasIdx}.item_id " : '';
			}
			else {
				$query .= $aliasIdx >= 2 ? "INNER JOIN " : '';
				$query .= "(SELECT created_at, {$fields} ";
				$query .= "FROM {$table} ";
				$query .= "WHERE item_id IN ({$ids}) AND created_at >= '{$startDate}' AND created_at <= '{$endDate}' ";
				$query .= "GROUP BY created_at) as t{$aliasIdx} ";
				$query .= $aliasIdx >= 2 ? "ON t1.created_at=t{$aliasIdx}.created_at " : '';
			}

			$aliasIdx++;
		}

		$query .= ") as t ORDER BY created_at DESC";

		return preg_replace("/PARTIAL_STRING/", rtrim($partialString, ","), $query);
	}


	/**
	 * Devuelve un string de kpis o parciales para añadir en el select.
	 * (t1.c1 + t1.c2 + t1.c3) as kpi
	 * (c1 + c2 + c3) as kpi
	 * 
	 * @param  $items
	 * @param  string $alias
	 * @return string
	 */
	private function formatString($items, $alias = '')
	{
		$response = '';

		foreach ($items as $item) {
			$response .= $alias != ''
				? '(' . preg_replace('/c/i', "{$alias}.c", $item->equation) . ') as ' . $item->name . ','
				: '(' . $item->equation . ') as ' . $item->name . ',';
		}

		return rtrim($response, ",");
	}


	/**
	 * Devuelve un string con los nombres de los campos
	 * de la tabla con formato normal o agregado.
	 * 
	 * @param  string $key
	 * @return string
	 */
	private function getFields($vendor, $tech, $aggregate = false)
	{
		$fields = array_map(function($item) use ($aggregate) {
			return $aggregate
				? 'SUM(' . $item['db_name'] . ') as ' . $item['db_name']
				: $item['db_name'];

		}, config( "countersfields.{$vendor}.{$tech}" ));

		return implode(',', $fields);
	}


	/**
	 *  Extraigo la tecnología del nombre de la tabla.
	 *  
	 * @param  $table
	 * @return $tech
	 */
	private function techFrom($table)
	{
		return explode('_', $table)[1];
	}


	/**
	 *  Extraigo el vendo del nombre de la tabla.
	 *  
	 * @param  $table
	 * @return $vendor
	 */
	private function vendorFrom($table)
	{
		return explode('.', $table)[0];
	}

}
