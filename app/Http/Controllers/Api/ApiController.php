<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

abstract class ApiController extends Controller
{
	protected $statusCode = 200;

	public function getStatusCode()
	{
		return $this->statusCode;
	}

	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;
		return $this;
	}

	public function respondNotFound($message = 'Not Found!')
	{
		return $this->setStatusCode(404)->respondWithError($message);
	}

	public function respondInternalError($message = 'Internal Error!')
	{
		return $this->setStatusCode(500)->respondWithError($message);
	}

	public function respond($data, $headers = [])
	{
		//return Response::json($data, $this->getStatusCode(), $headers);
		return new JsonResponse([
			'code'    => $this->getStatusCode(),
			'message' => 'OK',
			'data'  => $data
		]);

	}

	public function respondWithError($message = 'Not Found!')
	{
		return new JsonResponse([
			'code'    => $this->getStatusCode(),
			'message' => $message
		]);
				/*
		return $this->respond([
			'code' => $this->getStatusCode(),
			'message' => $message
		]);
		*/
	}
}