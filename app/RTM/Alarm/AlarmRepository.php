<?php

namespace App\RTM\Alarm;

use App\RTM\Alarm\Alarm;
use Illuminate\Support\Facades\DB;

class AlarmRepository
{
	/**
	 * Devuelve una instancia del modelo del repositorio.
	 * 
	 * @return Alarm
	 */
	public function getModel()
	{
		return new Alarm;
	}

	/**
	 * Inserto la alarma en la base de datos.
	 * 
	 * @param  $alarm
	 */
	public function insert(array $alarm)
	{
		$this->getModel()->create($alarm);
	}

	/**
	 * Obtengo todas las alarmas de un tipo dado.
	 * 
	 * @param  $type
	 * @return array
	 */
	public function all($type)
	{
		if($type == 'archive') {
			return $this->select('archive')
				->get()
				->toArray();
		}

		return $this->select('node')
			->get()
			->toArray();
	}

	/**
	 * Filtro las alarmas de un tipo dado por fecha y valor.
	 * 
	 * @param  array  $data
	 * @return array
	 */
	public function filter(array $data)
	{
		if($data['type'] == 'archive') {
			$query = $this->select('archive')
				->where('alarms.created_at', '>=', $data['start_date'])
				->where('alarms.created_at', '<=', $data['end_date']);

			if(count($data['values']) > 0) {
				$query = $query->whereIn('controllers.name', $data['values']);
			}

			return $query->get()->toArray();
		}

		return $this->select('public.node_alarms')
			->whereIn('nodes.name', $data['values'])
			->where('node_alarms.created_at', '>=', $data['start_date'])
			->where('node_alarms.created_at', '<=', $data['end_date'])
			->get()
			->toArray();
	}

	/**
	 * Creo la query sin filtros para obtener las alarmas de un tipo.
	 * 
	 * @param  $type
	 * @return query
	 */
	private function select($type)
	{
		if($type == 'archive') {
			return DB::table('public.alarms')
				->join('controllers', 'alarms.controller_id', '=', 'controllers.id')
				->join('kpis', 'alarms.kpi_id', '=', 'kpis.id')
				->select(
					'alarms.type',
					DB::raw("to_char(alarms.created_at, 'YYYY-mm-dd') as date"),
					DB::raw("to_char(alarms.created_at, 'HH24:MI') as time"),
					DB::raw("upper(alarms.vendor) as vendor"),
					DB::raw("upper(alarms.tech) as tech"),
					'controllers.name as controller',
					'kpis.name as kpi',
					'alarms.value',
					'alarms.relative_threshold as relative_difference',
					'alarms.threshold',
					'alarms.samples'
				)
				->orderBy('alarms.created_at', 'desc')
				->orderBy('controllers.name', 'asc');
		}

		return DB::table('public.node_alarms')
			->join('nodes', 'node_alarms.node_id', '=', 'nodes.id')
			->select(
				'nodes.name',
				DB::raw("to_char(node_alarms.created_at, 'YYYY-mm-dd') as date"),
				DB::raw("to_char(node_alarms.created_at, 'HH24:MI') as time"),
				'node_alarms.sever',
				'node_alarms.mo',
				'node_alarms.specific_problem'
			)
			->orderBy('node_alarms.created_at', 'desc')
			->orderBy('nodes.name', 'asc');
	}
}