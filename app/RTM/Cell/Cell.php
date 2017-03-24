<?php

namespace App\RTM\Cell;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cell extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cells';

	/**
	 * Does not have timestamps
	 */
	public $timestamps = true;

	/**
	 * Does not have incremental ID
	 */
	public $incrementing = true;


	public static function find($cells)
	{
		return DB::table('cells')
			->leftJoin('controllers', 'cells.controller_id', '=', 'controllers.id')
			->join('provinces', 'cells.province_id', '=', 'provinces.id')
			->whereIn('cells.name', $cells)
			->select(
				'cells.id',
				'cells.name',
				'cells.tech',
				'cells.vendor',
				'controllers.name as controller',
				'provinces.name as province'
			)
			->get()
			->toArray();
	}


}
