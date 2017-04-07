<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AlarmApiRequest;
use App\RTM\Alarm\AlarmRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AlarmController extends ApiController
{
	protected $alarmRepository;

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(AlarmRepository $alarmRepository)
	{
		$this->alarmRepository = $alarmRepository;
	}

	/**
	 * Filtro las alarmas.
	 * 
	 * @param  AlarmApiRequest $request
	 * @return json
	 */
	public function index(AlarmApiRequest $request)
	{
		$data = $request->formatData()->all();

		return $this->respond(
			$this->alarmRepository->filter($data)
		);
    }
}