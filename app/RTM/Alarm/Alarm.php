<?php

namespace App\RTM\Alarm;

use Illuminate\Database\Eloquent\Model;

class Alarm extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'alarms';

	/**
	 * Does not have timestamps
	 */
	public $timestamps = false;

	/**
	 * Does not have incremental ID
	 */
	public $incrementing = true;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'type',
		'created_at',
		'vendor',
		'tech',
		'controller_id',
		'cell_id',
		'kpi_id',
		'value',
		'relative_threshold',
		'threshold',
		'samples'
	];
}