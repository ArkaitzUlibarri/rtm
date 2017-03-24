<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Validator;

abstract class ApiRequest extends FormRequest
{
	/**
	 * Override response function.
	 * 
	 * @param  array
	 * @return json
	 */
	public function response(array $errors)
	{
		$errosList = array();
		
		foreach ($errors as $group) {
			foreach ($group as $message) {
				$errosList[] = $message;
			}
		}
		
		return new JsonResponse([
			'code'    => 406,
			'message' => 'Invalid Format!',
			'errors'  => $errosList,
		]);
	}

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	public function validator()
	{
		$validator = Validator::make(
			$this->input(),
			$this->rules(),
			$this->messages(),
			$this->attributes()
		);

		if(method_exists($this, 'moreValidation')){
			$this->moreValidation($validator);
		}

		return $validator;
	}
}
