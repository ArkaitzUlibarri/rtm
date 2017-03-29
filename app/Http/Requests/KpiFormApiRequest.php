<?php

namespace App\Http\Requests;

use App\RTM\Counter\Counter;
use App\RTM\Kpi\KpiRepository;
use Illuminate\Validation\Rule;

class KpiFormApiRequest extends ApiRequest
{
	private $kpiRepository;
	private $counter;

	/**
	 * Creo una nueva instancia de KpiFormApiRequest.
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
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'type' => [
				'required',
				Rule::in(config('filter.kpi_type'))
			],
			'name' => [
				'required',
				'between:3,50'
			],
			'tech' => [
				'required_unless:type,tech',
				Rule::in(config('filter.technologies'))
			],
			'vendor' => [
				'required_unless:type,vnd',
				Rule::in(config('filter.vendor'))
			],
			'symbol_red' => [
				Rule::in($this->getArrayFrom('symbols'))
			],
			'threshold_red' => [
				'required_with:symbol_red'
			],
			'threshold_aggregate_red' => [
				'required_with:symbol_red'
			],
			'symbol_yellow' => [
				Rule::in($this->getArrayFrom('symbols'))
			],
			'threshold_yellow' => [
				'required_with:symbol_yellow'
			],
			'threshold_aggregate_yellow' => [
				'required_with:symbol_yellow'
			],
			'threshold_relative' => [
				'required_with:threshold_aggregate_relative',
				'required_with:threshold_relative_condition'
			],
			'threshold_relative_condition_kpi' => [
				'required_with:threshold_relative_condition',
			],
			'threshold_relative_condition' => [
				'required_with:threshold_relative_condition_kpi',
			],
			'threshold_relative_n' => [
				'required_with:threshold_relative'
			],
			'threshold_aggregate_relative_n' => [
				'required_with:threshold_aggregate_relative'
			],
			'threshold_aggregate_absolute_n' => [
				'required_with:threshold_aggregate_absolute'
			],
			'equation' => [
				'required'
			],
		];
	}



	/**
	 * Validaciones extras despues de la validación principal.
	 *
	 * @return array
	 */
	public function moreValidation($validator)
	{
		$validator->after(function($validator) {

			$name = $this->normalize($this['name']);

			// Compruebo que no exista un kpi con la convinacion deseada.
			switch($this->method())
			{
				case 'PATCH':
				{
					if($this->kpiRepository->exists(
						$this['type'],
						$name,
						$this['vendor'],
						$this['tech'],
						$this['id'])) {

						$validator->errors()->add(
							'name', 'The kpi already exists for current vendor-tech-type.'
						);
					}

					break;
				}

				case 'POST':
				{
					if($this->kpiRepository->exists(
						$this['type'],
						$name,
						$this['vendor'],
						$this['tech'])) {

						$validator->errors()->add(
							'name', 'The kpi already exists for current vendor-tech-type.'
						);
					}
					break;
				}
			}

			// Transformo la equacion a formato de base de datos y la valido 
			$this['equation'] = $this->counter->toDatabase(
				$this['equation'],
				$this['vendor'],
				$this['tech']
			);

			if(! $this->counter->validate($this['equation'], $this['vendor'], $this['tech'])) {
				$validator->errors()->add(
					'equation', 'Equation does not pass the validation test!'
				);
			}

			// Compruebo que los threshold principales sea numeros cuando se trate de un kpi estandar.
			if($this['type'] == 'std') {
				$thresholds = [
					'threshold_red'              => ['symbol' => 'symbol_red', 'text' => 'main threshold'],
					'threshold_aggregate_red'    => ['symbol' => 'symbol_red', 'text' => 'main aggregate threshold'],
					'threshold_yellow'           => ['symbol' => 'symbol_yellow', 'text' => 'second threshold'],
					'threshold_aggregate_yellow' => ['symbol' => 'symbol_yellow', 'text' => 'second aggregate threshold']
				];
			
				foreach ($thresholds as $key => $value) {
					if(! is_numeric($this[$key]) && $this[$value['symbol']] != null) {
						$validator->errors()->add(
							$key, "The {$value['text']} must be a number."
						);
					}
				}
			}
		});
	}


	/**
	 * Actualizo valores en fucnion del tipo de KPI.
	 * 
	 * @return $this
	 */
	public function formatData()
	{
		$fields = array();

		if(request()->get('type') != 'std') {
			$fields = [
				'threshold_aggregate_relative',
				'threshold_aggregate_relative_n',
				'threshold_relative',
				'threshold_relative_n',
				'threshold_relative_condition',
				'threshold_relative_condition_kpi',
				'threshold_aggregate_absolute',
				'threshold_aggregate_absolute_n',
			];

			if(request()->get('type') == 'prt') {
				$fields[] = 'symbol_red';
				$fields[] = 'threshold_red';
				$fields[] = 'threshold_aggregate_red';
				$fields[] = 'symbol_yellow';
				$fields[] = 'threshold_yellow';
				$fields[] = 'threshold_aggregate_yellow';
			}

			if(request()->get('type') == 'vnd') {
				$fields[] = 'vendor';
			}

			if(request()->get('type') == 'tech') {
				$fields[] = 'tech';
			}

		}
		else {
			// Si no se ha seleccionado un simbolo principal borro los umbrales principales.
			if(request()->get('symbol_red') == '') {
				$fields[] = 'symbol_red';
				$fields[] = 'threshold_red';
				$fields[] = 'threshold_aggregate_red';
			}

			// Si no se ha seleccionado un simbolo secundario borro los umbrales secundario.
			if(request()->get('symbol_yellow') == '') {
				$fields[] = 'symbol_yellow';
				$fields[] = 'threshold_yellow';
				$fields[] = 'threshold_aggregate_yellow';
			}
		}

		$this['name'] = $this->normalize($this['name']);

		foreach ($fields as $key => $value) {
			$this[$value] = null;
		}

		return $this;
	}


	/**
	 * Normalizo el nombre del kpi o parcial
	 * 
	 * @param  $name
	 * @return string
	 */
	private function normalize($name)
	{
		$name = trim(strtolower($name));

		return preg_replace("/\s/", '_', $name);
	}


	/**
	 * Devuelvo un array del fichero de configuracion 'filter'.
	 * Si es el elemento 'symbols' le añado un campo vacio.
	 * 
	 * @param  $name
	 * @return array
	 */
	private function getArrayFrom($name)
	{
		$array = config('filter.' . $name);
		
		if($name == 'symbols') {
			array_push($array, '');
		}

		return $array;
	}


	/**
	* Custom messages.
	* 
	* @return array
	*/
	public function messages(){
		return [
			'symbol_red.required_if' => 'The main symbol field is required if type is in std.',
			'symbol_red.in' => 'The selected main symbol is invalid.',
			'threshold_red.required_with' => 'The main threshold field is required when main symbol is present.',
			'threshold_aggregate_red.required_with' => 'The main aggregate threshold field is required when main symbol is present.',
			'symbol_yellow.required_if' => 'The second symbol field is required if type is in std.',
			'symbol_yellow.in' => 'The selected second symbol is invalid.',
			'threshold_yellow.required_with' => 'The second threshold field is required when second symbol is present.',
			'threshold_aggregate_yellow.required_with' => 'The second aggregate threshold field is required when second symbol is present.',
		];
	}

}
