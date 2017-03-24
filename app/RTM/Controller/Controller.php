<?php

namespace App\RTM\Controller;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Controller extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'controllers';

	/**
	 * Does not have timestamps
	 */
	public $timestamps = true;

	/**
	 * Does not have incremental ID
	 */
	public $incrementing = true;


	public static function find($controllers)
	{
		return DB::table('controllers')
			->join('provinces', 'controllers.province_id', '=', 'provinces.id')
			->whereIn('controllers.name', $controllers)
			->select(
				'controllers.id',
				'controllers.name',
				'controllers.vendor',
				'controllers.tech',
				'provinces.name as province'
			)
			->get()
			->toArray();
	}

	public static function findCells($controller)
	{
		$data = DB::table('controllers')
			->join('cells', 'controllers.id', '=', 'cells.controller_id')
			->join('provinces', 'cells.province_id', '=', 'provinces.id')
			->whereIn('controllers.name', $controller)
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

		if($data == []) {
			$data = DB::table('provinces')
				->join('cells', 'provinces.id', '=', 'cells.province_id')
				->whereIn('provinces.code', $controller)
				->where('cells.tech', '=', '4g')
				->select(
					'cells.id',
					'cells.name',
					'cells.tech',
					'cells.vendor',
					'provinces.name as province'
				)
				->get()
				->toArray();
		}

		return $data;
	}

	public static function findByZone($zone, $vendor, $tech)
	{
		return DB::table('provinces')
			->join('controllers', 'provinces.id', '=', 'controllers.province_id')
			->where('provinces.zone', $zone)
			->where('controllers.vendor', $vendor)
			->where('controllers.tech', $tech)
			->select(
				'controllers.id',
				'controllers.name',
				'controllers.vendor',
				'controllers.tech',
				'provinces.name as province'
			)
			->get()
			->toArray();
	}

}
