<?php

namespace App\RTM\Counter;

class Counter
{
	protected $databaseToHuman;
	protected $humaToDatabase;

	/**
	 * Inicializo los diccionarios con las traducciones en
	 * ambos sentidos (OSS -> db, db -> OSS).
	 */
	public function __construct()
	{
		$this->databaseToHuman = array();
		$this->humaToDatabase = array();

		foreach (config('filter.vendor') as $vendor) {

			foreach (config('filter.technologies') as $tech) {

				foreach (config('countersfields')[$vendor][$tech] as $value) {
					$this->databaseToHuman[$vendor][$tech][$value['db_name']] = $value['oss_name'];
				}

				foreach (config('countersfields')[$vendor][$tech] as $value) {
					$this->humaToDatabase[$vendor][$tech][$value['oss_name']] = $value['db_name'];
				}
			}
		}
	}

	/**
	 * Traduzco una equacion con formato de base de datos a una con formato humano.
	 * 
	 * @param  $equation	c1+c2+c3*3
	 * @param  $vendor
	 * @param  $tech
	 * @return $equation	OSS1+OSS2+OSS3*3
	 */
	public function toHuman($equation, $vendor, $tech)
	{
		if($vendor == null || $tech == null) {
			return $equation;
		}

		foreach ($this->databaseToHuman[$vendor][$tech] as $key => $value) {
			$equation = preg_replace("/({$key})\b/", $value, $equation);
		}

		return $equation;
	}


	/**
	 * Traduzco una equacion con formato humano a formato de base de datos.
	 * 
	 * @param  $equation	OSS1+OSS2+OSS3*3
	 * @param  $vendor
	 * @param  $tech
	 * @return $equation	c1+c2+c3*3
	 */
	public function toDatabase($equation, $vendor, $tech)
	{
		if($vendor == null || $tech == null) {
			return $equation;
		}

		foreach ($this->humaToDatabase[$vendor][$tech] as $key => $value) {
			$equation = preg_replace("/({$key})\b/", $value, $equation);
		}

		return $equation;
	}


	/**
	 * Valido una equacion.
	 * 
	 * @param  $equation	c1+c2+c3*3
	 * @param  $vendor
	 * @param  $tech
	 * @return $equation	Validation OK  -> c1+c2+c3*3
	 *                      Validation NOK -> false
	 */
	public function validate($equation, $vendor, $tech)
	{
		// Elimino los contadores
		if($vendor != null && $tech != null) {
			foreach ($this->databaseToHuman[$vendor][$tech] as $key => $value) {
				$equation = preg_replace("/({$key})\b/", '', $equation);
			}
		}

		// Elimino los parciales
		$equation = preg_replace ("/([p]\d+)/", '', $equation);

		// Elimino operaciones y parentesis
		if(preg_replace("/[()0123456789+\-\*\/]/", '', $equation) == '') {
			return true;
		}

		return false;
	}
}