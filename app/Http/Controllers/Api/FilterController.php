<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\FilterApiRequest;
use App\RTM\Filter\FilterService;

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

		$data = $this->filterService->process($input);

		if(! is_array($data)) {
			return $this->respondBadRequest($data);
		}

		return $this->respond($data);
	}
}