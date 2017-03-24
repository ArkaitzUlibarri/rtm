<?php

namespace App\RTM\Node;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Node extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'nodes';

	/**
	 * Does not have timestamps
	 */
	public $timestamps = true;

	/**
	 * Does not have incremental ID
	 */
	public $incrementing = true;



	public static function findCells($node, $tech)
	{
		$data = DB::table('nodes')
			->join('cells', 'nodes.id', '=', 'cells.node_id')
			->whereIn('nodes.name', $node)
			->select(
				'cells.id',
				'cells.name',
				'cells.tech',
				'cells.vendor',
				'nodes.name as node'
			);
			

		if($tech != 'aggregate') {
			$data = $data->where('cells.tech', $tech);
		}

		return $data->get()->toArray();
	}
}
