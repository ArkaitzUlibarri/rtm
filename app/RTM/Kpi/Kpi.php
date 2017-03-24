<?php

namespace App\RTM\Kpi;

use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'kpis';

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
		'name',
		'tech',
		'vendor',
		'type',
		'equation',
		'symbol_red',
		'threshold_red',
		'threshold_aggregate_red',
		'symbol_yellow',
		'threshold_yellow',
		'threshold_aggregate_yellow',
		'threshold_relative',
		'threshold_relative_n',
		'threshold_relative_condition',
		'threshold_relative_condition_kpi',
		'threshold_aggregate_relative',
		'threshold_aggregate_relative_n',
		'threshold_aggregate_absolute',
		'threshold_aggregate_absolute_n'
	];
}