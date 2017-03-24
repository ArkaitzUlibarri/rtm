<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;

class CounterController extends ApiController
{
	public function index()
	{
		return new JsonResponse([
			'code'    => 200,
			'message' => 'OK',
			'data' => config('countersfields')
		]);
    }
}
