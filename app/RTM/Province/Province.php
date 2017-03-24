<?php

namespace App\RTM\Province;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Province extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'provinces';

	/**
	 * Does not have timestamps
	 */
	public $timestamps = true;


	public static function find($provinces, $vendor, $tech)
	{
		$response = DB::table('provinces')
			->whereIn('code', $provinces)
			->select(
				'id',
				'name',
				DB::raw("'{$vendor}' as vendor, '{$tech}' as tech")
			)
			->get()
			->toArray();

		if ($vendor == 'aggregate') {
			return Province::cloneEntriesBy(
				'vendor',
				config('filter.vendor'),
				$response
			);
		}

		if ($tech == 'aggregate') {
			return Province::cloneEntriesBy(
				'tech',
				config('filter.technologies'),
				$response
			);
		}

		return $response;
	}



	public static function findByZone($zone, $vendor, $tech)
	{
		return DB::table('provinces')
			->where('zone', $zone)
			->select(
				'id',
				'name',
				DB::raw("'{$vendor}' as vendor, '{$tech}' as tech")
			)
			->get()
			->toArray();
	}


	private static function cloneEntriesBy($field, $array, $data)
	{
		$response = array();

		foreach ($array as $item) {
			foreach ($data as $entry) {
				$newEntry = clone $entry;
				$newEntry->$field = $item;
				$response[] = $newEntry; 
			}
		}

		return $response;
	}
}
