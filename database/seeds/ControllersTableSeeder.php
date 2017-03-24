<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ControllersTableSeeder extends Seeder
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

		$controllers = SeederConfig::CONTROLLERS;
    	$provinces = $this->provinces();

		foreach ($controllers as $vendor => $value)
		{
			foreach ($value as $tech => $count)
			{			
				for ($i=1; $i <= $count; $i++)
				{ 
					$controller = $tech == '2g' ? 'BSC' : 'RNC';

					DB::table('controllers')->insert([
						'name'        => $controller . '_' . strtoupper(substr($vendor, 0, 1)) . '_' . $i,
						'province_id' => $faker->randomElement($provinces),
						'vendor'      => $vendor,
						'tech'        => $tech
					]);
				}
			}			
		}

    }
}
