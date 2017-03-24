<?php

use App\RTM\Cell\Cell;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CellsTableSeeder extends Seeder
{
	use SeederHelpers;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$faker = Faker::create();

		$cells       = SeederConfig::CELLS;				// Celdas por vendro y tecnologia
		$batchSize   = SeederConfig::BATCH_SIZE;		// Registros a insertar por transaccion
		$nodes       = $this->nodesWithControllers();	// Array de ids de nodo
		
		$id = ['eri' => 1, 'hua' => 1];

		foreach ($cells as $vendor => $value) 
		{
			foreach ($value as $tech => $count) 
			{
				$numberBatch = ceil($count/$batchSize);

				for ($batch = 1; $batch <= $numberBatch; $batch++)
				{ 
					$data = array();

					for ($i = 1; $i <= $batchSize; $i++)
					{
						$node =  $faker->randomElement($nodes[$vendor]);

						$data[] = [
							'name'          => 'C' . strtoupper(substr($vendor, 0, 1)) . $id[$vendor],
							'tech'          => $tech,
							'vendor'        => $vendor,
							'node_id'       => $node['id'],
							'controller_id' => $node['controllers'][$tech]['controller'],
							'province_id'   => $node['controllers'][$tech]['province_id'],
						];

						$id[$vendor]++;
					}

					Cell::insert($data);
				}
			}
		}
    }

}
