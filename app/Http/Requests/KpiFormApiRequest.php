<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class KpiFormApiRequest extends ApiRequest
{


/*
type: '',
equation: '',
symbol_red: '',
threshold_red: '',
threshold_aggregate_red: '',
symbol_yellow: '',
threshold_yellow: '',
threshold_aggregate_yellow: '',
threshold_relative: '',
threshold_relative_n: 4,
threshold_relative_condition: '',
threshold_relative_condition_kpi: '',
threshold_aggregate_relative: '',
threshold_aggregate_relative_n: 4,
threshold_aggregate_absolute: '',
threshold_aggregate_absolute_n: 4
*/
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'name' => [
				'required'
			],
			'tech' => [
				'required',
				Rule::in(config('filter.technologies'))
			],
			'vendor' => [
				'required',
				Rule::in(config('filter.vendor'))
			]
		];
	}
}
