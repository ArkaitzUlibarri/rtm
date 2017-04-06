<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AlarmApiRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AlarmController extends ApiController
{
	public function index(AlarmApiRequest $request)
	{
		$data = $request->formatData()->all();

		return $this->respond(
			$this->fetchItems($data)
		);
    }




    private function fetchItems(array $data)
	{
		if($data['type'] == 'archive') {
			$query = DB::table('public.alarms')
				->join('controllers', 'alarms.controller_id', '=', 'controllers.id')
				->join('kpis', 'alarms.kpi_id', '=', 'kpis.id')
				->where('alarms.created_at', '>=', $data['start_date'])
				->where('alarms.created_at', '<=', $data['end_date'])
				->select(
					'alarms.type',
					DB::raw("to_char(alarms.created_at, 'YYYY-mm-dd') as date"),
					DB::raw("to_char(alarms.created_at, 'HH24:MI') as time"),
					DB::raw("upper(alarms.vendor) as vendor"),
					DB::raw("upper(alarms.tech) as tech"),
					'controllers.name as controller',
					'kpis.name as kpi',
					'alarms.value',
					'alarms.relative_threshold as relative_th',
					'alarms.threshold',
					'alarms.samples'
				);

			if(count($data['values']) > 0) {
				$query = $query->whereIn('controllers.name', $data['values']);
			}

			return $query->orderBy('alarms.created_at', 'desc')
				->orderBy('controllers.name', 'asc')
				->get()
				->toArray();
		}

		return DB::table('public.node_alarms')
			->join('nodes', 'node_alarms.node_id', '=', 'nodes.id')
			->whereIn('nodes.name', $data['values'])
			->where('node_alarms.created_at', '>=', $data['start_date'])
			->where('node_alarms.created_at', '<=', $data['end_date'])
			->select(
				'nodes.name',
				DB::raw("to_char(node_alarms.created_at, 'YYYY-mm-dd') as date"),
				DB::raw("to_char(node_alarms.created_at, 'HH24:MI') as time"),
				'node_alarms.sever',
				'node_alarms.mo',
				'node_alarms.specific_problem'
			)
			->orderBy('node_alarms.created_at', 'desc')
			->orderBy('nodes.name', 'asc')
			->get()
			->toArray();
	}


}