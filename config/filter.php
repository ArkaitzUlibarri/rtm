<?php

return [

	/*
	|--------------------------------------------------------------------------
	| By
	|--------------------------------------------------------------------------
	|
	| Filter "by" with max items available to process for each one.
	|
	*/
	'by' => [
		'cell' => [
			'name'      => 'Cell',
			'table'     => '',
			'max_items' => 10
		],
		'node' => [
			'name'      => 'Node',
			'table'     => '',
			'max_items' => 3
		],
		'controller_cell' => [
			'name'      => 'Cells By Controller',
			'table'     => '',
			'max_items' => 1
		],
		'controller' => [
			'name'      => 'Controller',
			'table'     => '_controller',
			'max_items' => 10
		],
		'province' => [
			'name'      => 'Province',
			'table'     => '_province',
			'max_items' => 10
		],
		'zone' => [
			'name'         => 'Zone',
			'table'        => '_controller',
			'max_items'    => 1,
			'aggregate_by' => [
				'2g' => ['controller', 'province'],
				'3g' => ['controller', 'province'],
				'4g' => ['province']
			]
		],
	],


	/*
	|--------------------------------------------------------------------------
	| Technologies
	|--------------------------------------------------------------------------
	|
	| Available technologies.
	|
	*/
	'technologies' => [ '2g', '3g', '4g' ],


	/*
	|--------------------------------------------------------------------------
	| Vendor
	|--------------------------------------------------------------------------
	|
	| Available vendors.
	|
	| ERI = Ericsson, HUA = Huawei
	|
	*/
	'vendor' => [ 'eri', 'hua' ],


	/*
	|--------------------------------------------------------------------------
	| Zones
	|--------------------------------------------------------------------------
	|
	| Available zone name and integer value.
	|
	*/
	'zones' => [
		[ 'name'  => 'Zone 1', 'value' => 1 ],
		[ 'name'  => 'Zone 2', 'value' => 2 ],
		[ 'name'  => 'Zone 3', 'value' => 3 ],
		[ 'name'  => 'Zone 4', 'value' => 4 ],
		[ 'name'  => 'Zone 5', 'value' => 5 ],
		[ 'name'  => 'Zone 6', 'value' => 6 ], 
	],


	/*
	|--------------------------------------------------------------------------
	| Period type configuration
	|--------------------------------------------------------------------------
	|
	| Subtract hours to original "to" date to set "from" date.
	|
	*/
	'for' => [
		'last1h' => [
			'name'  => '1 Hour',
			'hours' => 1,
			'resolutions' => [
				[ 'name' => 'ROP', 'value' => 'rop' ],
				[ 'name' => 'Hour', 'value' => 'hour' ],
			]
		],
		'last3h' => [
			'name'  => '3 Hours',
			'hours' => 3,
			'resolutions' => [
				[ 'name' => 'ROP', 'value' => 'rop' ],
				[ 'name' => 'Hour', 'value' => 'hour' ],
			]
		],
		'last6h' => [
			'name'  => '6 Hours',
			'hours' => 6,
			'resolutions' => [
				[ 'name' => 'ROP', 'value' => 'rop' ],
				[ 'name' => 'Hour', 'value' => 'hour' ],
			]
		],
		'last12h' => [
			'name'  => '12 Hours',
			'hours' => 12,
			'resolutions' => [
				[ 'name' => 'Hour', 'value' => 'hour' ],
				[ 'name' => 'ROP', 'value' => 'rop' ],
			]
		],
		'last1d' => [
			'name'  => '1 Day',
			'hours' => 24,
			'resolutions' => [
				[ 'name' => 'Hour', 'value' => 'hour' ],
				[ 'name' => 'ROP', 'value' => 'rop' ],
			]
		],
		'last3d' => [
			'name'  => '3 Days',
			'hours' => 72,
			'resolutions' => [
				[ 'name' => 'Hour', 'value' => 'hour' ],
				[ 'name' => 'Day', 'value' => 'day' ],
			]
		],
		'last7d' => [
			'name'  => '7 Days',
			'hours' => 168,
			'resolutions' => [
				[ 'name' => 'Day', 'value' => 'day' ],
			]
		],
		'last28d' => [
			'name'  => '28 Days',
			'hours' => 672,
			'resolutions' => [
				[ 'name' => 'Day', 'value' => 'day' ],
			]
		],
	],
];