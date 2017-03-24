<?php

use Carbon\Carbon;

class SeederConfig
{
	/**
	 * Fecha de inicio y fin para crear contadores.
	 */
	public static function START_DATE() {
		return Carbon::create(2017, 3, 21, 18, 15, 0);
	}

	public static function END_DATE() {
		return Carbon::create(2017, 3, 22, 18, 0, 0);
	}

	/**
	 * Controladores disponibles por vendor y tecnología.
	 */
	const CONTROLLERS = [
		'eri' => [ '2g' => 5, '3g' => 10 ],
		'hua'=>  [ '2g' => 4, '3g' => 5 ]
		//'eri' => [ '2g' => 30, '3g' => 70 ],
		//'hua'=>  [ '2g' => 23, '3g' => 26 ]
	];

	/**
	 * Nodos disponibles.
	 */
	const NODES = 50;
	// const NODES = 50000;

	/**
	 * Celdas ha crear por vendor y tecnología.
	 */
	const CELLS = [
		'eri' => [ '2g' => 40, '3g' => 90, '4g' => 30 ],
		'hua'=>  [ '2g' => 30, '3g' => 70,  '4g' => 40 ]
		//'eri' => [ '2g' => 35000, '3g' => 104000, '4g' => 16000 ],
		//'hua'=>  [ '2g' => 22000, '3g' => 49000,  '4g' => 15000 ]
	];

	/**
	 * Tecnologías disponibles.
	 */
	const TECHNOLOGIES = ['2g', '3g', '4g'];

	/**
	 * Valores para lo contadores para hacer pruebas.
	 */
	const COUNTER_VALUES = [
		'eri' => [ '2g' => 1, '3g' => 2, '4g' => 3 ],
		'hua'=>  [ '2g' => 4, '3g' => 5,  '4g' => 6 ]
	];

	/**
	 * Numero de registros que se insertan por transacción. Tiene que ser
	 * multiplo y menor que el numero de celdas por vendor y tecnologia
	 */
	const BATCH_SIZE = 10;
	//const BATCH_SIZE = 500;
}