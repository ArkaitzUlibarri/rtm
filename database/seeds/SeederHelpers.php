<?php

use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

trait SeederHelpers
{
	/**
	 * Obtengo un array de los ids de provincias.
	 * 
	 * @return array
	 */
	private function provinces()
	{
		$array = DB::table('provinces')
			->select('id')
			->get();

		return array_pluck($array, 'id');
	}

	/**
	 * Obtengo un array asociativo de nodos.
	 * 
	 * @return array
	 */
	private function nodes()
	{
		$response = array();

		$nodes = DB::table('nodes')
			->select('id')
			->get();

		foreach ($nodes as $node) {
			$response[$node->id] = [
				'id' => $node->id
			];
		}

		return $response;
	}

	/**
	 * Obtengo un array asociativo de controladores.
	 * 
	 * @return array
	 */
	private function controllers()
	{
		$response = array();

		$controllers = DB::table('controllers')
			->select('id', 'vendor', 'tech', 'province_id')
			->get()
			->toArray();

		foreach ($controllers as $controller) {
			$response[$controller->id] = [
				'id'          => $controller->id,
				'vendor'      => $controller->vendor,
				'tech'        => $controller->tech,
				'province_id' => $controller->province_id
			];
		}

		return $response;
	}


	/**
	 * Obtengo un array asociativo de controladores por vendor y tecnología.
	 * 
	 * @return array
	 */
	private function controllersByVendorTech()
	{
		$response = array();

		$controllers = DB::table('controllers')
			->select('id', 'vendor', 'tech', 'province_id')
			->get()
			->toArray();

		foreach ($controllers as $controller) {
			$response[$controller->vendor][$controller->tech][$controller->id] = [
				'id'          => $controller->id,
				'province_id' => $controller->province_id
			];
		}

		return $response;
	}


	/**
	 * Obtengo un array asociativo de nodos por vendor
	 * con sus controladores por tecnologia asociados.
	 * 
	 * @return array
	 */
	private function nodesWithControllers()
	{
		$faker = Faker::create();

		$response = array();
		$nodes = $this->nodes();
		$controllers = $this->controllersByVendorTech();
		$provinces = $this->provinces();

		for ($id=count($nodes); $id > 0; $id--)
		{ 
			$vendor =  $faker->randomElement(['eri', 'hua']);

			$controller2g   = $faker->randomElement($controllers[$vendor]['2g']);
			$controller3g   = $faker->randomElement($controllers[$vendor]['3g']);

			$response[$vendor][$id] = [
				'id'          => $id,
				'vendor'      => $vendor,
				'controllers'  => [
					'2g' => [
						'controller'  => $controller2g['id'],
						'province_id' => $controller2g['province_id'],
					],
					'3g' => [
						'controller'  => $controller3g['id'],
						'province_id' => $controller3g['province_id'],
					],
					'4g' => [
						'controller'  => null,
						'province_id' => $faker->randomElement($provinces),
					],
				]
			];
		}

		return $response;
	}


	/**
	 * Make a line to insert into the database
	 * 
	 * @param  $id            item's id
	 * @param  $date          Current date time
	 * @param  $numberFields  number of fields for the current vendor/tech row
	 * @param  $faker
	 * 
	 * @return [
	 *     'item_id' => $id,
	 *     'created_at' => $date,
	 *     'c1' => x,
	 *     'c2' => x,
	 *     ...
	 * ]
	 */
	private function makeEntry($id, $date, $numberFields, $value) {
		$faker = Faker::create();

		$data = [
			'item_id'    => $id,
			'created_at' => $date,
		];

		for ($i = 1; $i <= $numberFields; $i++) { 
			//$data['c' . $i] = $value;
			$data['c' . $i] = $faker->numberBetween(0, 255);
		}

		return $data;
	}
}