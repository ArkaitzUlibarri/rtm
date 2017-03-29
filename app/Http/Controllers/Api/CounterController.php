<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;

class CounterController extends ApiController
{
	public function index()
	{
		return $this->respond(config('countersfields'));
    }
}
