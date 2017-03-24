<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Validation\Rule;

class FilterApiRequest extends ApiRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'by' => [
				'required',
				Rule::in(array_keys(config('filter.by'))),
			],
			'tech' => [
				'required_if:by,node',
				'required_if:by,province',
				'required_if:by,zone',
				Rule::in($this->getArrayFrom('technologies'))
			],
			'vendor' => [
				'required_if:by,province',
				'required_if:by,zone',
				Rule::in($this->getArrayFrom('vendor'))
			],
			'end_date' => [
				'required',
				'date_format:"Y-m-d H:i"',
			],
			'for' => [
				'required',
				Rule::in(array_keys(config('filter.for')))
			],
			'resolution' => [
				'required',
				Rule::in($this->getResolutions(request()->get('for'))),
			],
			'zone' => [
				'required_if:by,zone',
				Rule::in(array_pluck(config('filter.zones'), 'value'))
			],
			'zone_aggregate' => [
				'required_if:by,zone',
				Rule::in($this->getAggregates())
			],
			'values' => [
				'required_unless:by,zone',
			]
		];
	}

	/**
	 * After validation hook.
	 *
	 * @return array
	 */
	public function moreValidation($validator)
	{
		$validator->after(function($validator) {
			if(array_key_exists($this->input('by'), config('filter.by'))) {
				
				$maxValues = config('filter.by')[$this->input('by')]['max_items'];

				if ($maxValues < count(explode(',', $this->input('values')))) {
					$validator->errors()->add('values', "Can't be more than {$maxValues} values.");
				}
			}
		});
	}

	/**
	 * Set Carbon instances of dates and explode input values to make an array.
	 * 
	 */
	public function formatData()
	{
		if(request()->get('by') != 'zone') {
			$this['values'] = explode(',', strtoupper($this['values']));
		}

		$this['end_date'] = Carbon::createFromFormat('Y-m-d H:i', $this['end_date']);

		$this['start_date'] = $this['end_date']->copy()->subHours(
			config('filter.for')[$this['for']]['hours']
		);

		return $this;
	}


	/**
	 * Get the valid resolutions for current "for" field.
	 *
	 * @return array
	 */
	private function getResolutions($for)
	{
		if(array_key_exists($for, config('filter.for'))) {
			return array_map(function($item) {
				return $item['value'];
			}, config('filter.for')[$for]['resolutions']);
		}

		return array();
	}


	private function getArrayFrom($name)
	{
		$array = config('filter.' . $name);
		
		if( request()->get('by') == 'node' ||
			request()->get('by') == 'province' ) {
			array_push ($array, 'aggregate');
		}

		return $array;
	}

	private function getAggregates()
	{
		if(array_key_exists(
			request()->get('tech'),
			config('filter.by')['zone']['aggregate_by'] )) {
			return config('filter.by')['zone']['aggregate_by'][request()->get('tech')];
		}
		
		return [];
	}


	/**
	 * Custom messages.
	 * 
	 * @return array
	 */
    public function messages(){
        return [
            'zone_aggregate.in' => 'The selected zone aggregate is invalid for current tech.'
        ];
    }

}
