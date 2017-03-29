<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\KpiFormApiRequest;
use App\RTM\Counter\Counter;
use App\RTM\Kpi\Kpi;
use App\RTM\Kpi\KpiRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class KpiController extends ApiController
{
	private $kpiRepository;
	private $counter;


    /**
     * Creo una nueva instancia de ApiController.
     *
     * @return void
     */
	public function __construct(
		KpiRepository $kpiRepository,
		Counter $counter)
	{
		$this->kpiRepository = $kpiRepository;
		$this->counter = $counter;
	}


	/**
	 * Filtro los kpis dependientes de un parcial en concreto.
	 * 
	 * @param  Request $request
	 * @return json
	 */
	public function dependencies(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'partial' => 'required'
		]);

        if ($validator->fails()) {
			return $this->respondNotAcceptable($validator->errors()->all());
        }

        $data = $this->kpiRepository->dependenciesBy(
        	$request->get('partial')
        );

		return $this->respond($data);
	}


	/**
	 * Filtro los parciales por vendor y tecnologia.
	 * 
	 * @param  Request $request
	 * @return json
	 */
	public function partials(Request $request)
	{
		$validator = Validator::make($request->all(), [
            'vendor' => 'required|' . Rule::in(config('filter.vendor')),
            'tech' => 'required|' . Rule::in(config('filter.technologies'))
        ]);

        if ($validator->fails()) {
			return $this->respondNotAcceptable($validator->errors()->all());
        }

		$data = DB::table('kpis')
			->where('type', '=', 'prt')
			->where('vendor', '=', $request->get('vendor'))
			->where('tech', '=', $request->get('tech'))
			->orderBy('name', 'desc')
			->select('id', 'name')
			->get();

		return $this->respond($data);
	}


	/**
	 * Filtro los kpis.
	 * 
	 * @return json
	 */
	public function index(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'type' => 'required|in:std,vnd,tech'
		]);

        if ($validator->fails()) {
        	return $this->respondNotAcceptable($validator->errors()->all());
        }

		$data = DB::table('kpis')
			->where('type', '=', strtolower($request->get('type')))
			->orWhere('type', '=', 'prt')
			->orderBy('type', 'desc')
			->orderBy('id', 'asc')
			->get();

		foreach ($data as $value) {
			$value->equation = $this->counter->toHuman(
				$value->equation,
				$value->vendor,
				$value->tech
			);
		}

		return $this->respond($data);
	}


	/**
	 * Actualizo un kpi o parcial.
	 * 
	 * @param  KpiFormApiRequest $request
	 * @param  $id
	 * @return json
	 */
	public function update(KpiFormApiRequest $request, $id)
	{
		$kpi = Kpi::find($id);

		if($kpi == null) {
			return $this->respondNotFound();
		}

		$kpi->update(
			$request->formatData()->all()
		);

		return $this->respond();
	}


	/**
	 * Creo un kpi o parcial.
	 * 
	 * @param  KpiFormApiRequest $request
	 * @return json
	 */
	public function store(KpiFormApiRequest $request)
	{
		$array = $request->formatData()->all();

		unset($array['id']);

		$kpi = DB::table('kpis')->insert($array);

		return $this->respond();
	}


	/**
	 * Elimino un kpi/parcial mediante el id.
	 * 
	 * @param  $id
	 */
	public function destroy($id)
	{
		$kpi = Kpi::find($id);

		if($kpi == null) {
			return $this->respondNotFound();
		}

		$kpi->delete();

		return $this->respond();
	}


}
