<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlarmsTableSeeder extends Seeder
{
	use SeederHelpers;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// Creo alarmas absolutas a los controladores
		$this->addAlarms('absolute', 'controller', '2g');
		$this->addAlarms('absolute', 'controller', '3g');
		$this->addAlarms('absolute', 'controller', '4g');
		//$this->addAlarms($provinces, 'cell');
    }


	private function addAlarms($alarm, $itemType, $tech)
	{
		$faker = Faker::create();
		$start = SeederConfig::START_DATE();	// Fecha inicio
		$end = SeederConfig::END_DATE();		// Fecha fin

		// Controladores o celdas a las que añadir alarmas
		$items = $this->getItems($itemType, $tech);

		$kpis = $this->getKpis($alarm);
		$now = $start->copy();

		while ($now <= $end)
		{
			$data = array();

			// Recorro los items
			foreach ($items as $item)
			{
				// Determino si el item tendra alarma para el rop actual
				if($faker->boolean(5)) {

					if($itemType == 'cell') {
						$cell_id = $item->cell_id;
						$controller_id = $item->controller_id;
						$vendor = $item->vendor;
						$tech = $item->tech;
					}
					else if($itemType == 'controller') {
						$cell_id = null;

						if($tech == '4g') {
							$controller_id = $item;
							$vendor = $faker->randomElement(SeederConfig::VENDORS);
							$tech = '4g';
						}
						else {
							$controller_id = $item->controller_id;
							$vendor = $item->vendor;
							$tech = $item->tech;
						}
					}

					$data[] = [
						'type'               => $alarm,
						'created_at'         => $now,
						'vendor'             => $vendor,
						'tech'               => $tech,
						'controller_id'      => $controller_id,
						'cell_id'            => $cell_id,
						'kpi_id'             => $faker->randomElement($kpis),
						'value'              => $faker->randomFloat(2, 80, 90),
						'relative_threshold' => $itemType == 'relative' ? $faker->numberBetween(2, 6) : null,
						'threshold'          => $faker->numberBetween(90, 95),
						'samples'            => $faker->numberBetween(1, 4)
					];
				}
			}

			if(count($data) > 0) {
				DB::table('public.alarms')->insert($data);
			}

			$now->addMinutes(15);
		}
    }


    private function getKpis($alarm)
    {
    	$data = array();

    	if($alarm == 'absolute') {
			$array = DB::table('kpis')
				->where('threshold_aggregate_absolute', '!=', null)
				->where('type', 'std')
				->select('id')
				->get();

			return array_pluck($array, 'id');
    	}

		return [];
    }


    private function getItems($itemType, $tech)
    {
		if($itemType == 'cell') {
			return DB::table('cells')
				->select('id as cell_id, controller_id', 'vendor', 'tech')
				->get();
		}

		if($tech == '4g') {
			return $this->provinces();
		}

		return DB::table('controllers')
			->where('tech', $tech)
			->select('id as controller_id', 'vendor', 'tech')
			->get();
    }


}
