<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Validation\Rule;

class AlarmApiRequest extends ApiRequest
{
    /**
     * Obtengo las reglas de validacion para la peticion.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'end_date' => [
                'required',
                'date_format:"Y-m-d H:i"'
            ],
            'for' => [
                'required',
                Rule::in(array_keys(config('filter.for')))
            ],
            'type' => [
                'required',
                'in:node,archive'
            ],
            'values' => [
                'required_without_all:tech,vendor'
            ],
            'tech' => [
                'required_without:values',
                Rule::in(config('filter.technologies'))
            ],
            'vendor' => [
                'required_without:values',
                Rule::in(config('filter.vendor'))
            ],
        ];
    }

    /**
     * Formateo los valores de entrada en array, creo una instancia de Carbon
     * con la fecha fin y otra con la de inicio en base a la de fin y el periodo
     * de tiempo seleccionado.
     * 
     */
    public function formatData()
    {
        if($this['values'] != null) {
            $this['values'] = explode(',', strtoupper($this['values']));
        }
        else {
            $this['values'] = [];
        }

        $this['end_date'] = Carbon::createFromFormat('Y-m-d H:i', $this['end_date'], 'Europe/Madrid');

        $this['start_date'] = $this['end_date']->copy()->subHours(
            config('filter.for')[$this['for']]['hours']
        );

        return $this;
    }
}
