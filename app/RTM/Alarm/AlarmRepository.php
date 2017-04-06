<?php

namespace App\RTM\Alarm;

use App\RTM\Alarm\Alarm;

class AlarmRepository
{
	/**
	 * Devuelve una instancia del modelo del repositorio.
	 * 
	 * @return Alarm
	 */
	public function getModel()
	{
		return new Alarm;
	}

	/**
	 * Inserto la alarma en la base de datos.
	 * 
	 * @param  $alarm
	 */
	public function insert(array $alarm)
	{
		$this->getModel()->create($alarm);
	}

}