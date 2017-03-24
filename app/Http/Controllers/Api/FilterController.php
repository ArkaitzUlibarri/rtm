<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\FilterApiRequest;
use App\RTM\Filter\FilterService;
use Illuminate\Http\JsonResponse;

class FilterController extends ApiController
{
	private $filterService;

	public function __construct(FilterService $filterService)
	{
		$this->filterService = $filterService;
	}

	public function index(FilterApiRequest $request)
	{
		$input = $request->formatData()->all();

		$response = $this->filterService->process($input);

		if(! is_array($response)) {
			return new JsonResponse([
				'code'    => 400,
				'message' => $response
			]);
		}

		return new JsonResponse([
			'code'    => 200,
			'message' => 'OK',
			'data'  => $response
		]);
	}
}