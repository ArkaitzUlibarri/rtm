<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NodeAlarmsTableSeeder extends Seeder
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

		$sever = ['min', 'maj', 'crit'];
		$type = ['ettext', 'hw', 'sw'];
		$names = [
			'Emergency Unlock of Software Licensi',
			'External Link Failure',
			'GracePeriodStarted',
			'License Key File Fault',
			'Resource Allocation Failure Service'
		];


		$first = DB::table('controllers')->select('name');
		$nodes = DB::table('nodes')->select('name')->union($first)->get();

		foreach ($nodes as $node)
		{
			$numberAlarms = $faker->numberBetween(0, 4);

			for ($i=0; $i < $numberAlarms; $i++) 
			{
				$createdAt = $faker->dateTimeBetween('-1 month', 'now');

				DB::table('node_alarms')->insert([
					'node'        => $node->name,
					'vendor'      => $faker->randomElement(SeederConfig::VENDORS),
					'tech'        => $faker->randomElement(SeederConfig::TECHNOLOGIES),
					'created_at'  => $createdAt,
					'alarm_date'  => $createdAt,
					'severity'    => $faker->randomElement($sever),
					'type'        => $faker->randomElement($type),
					'name'        => $faker->randomElement($names),
					'information' => $faker->sentence(3, true),
					'cause'       => $faker->sentence(2, true)
				]);
			}
		}
	}
}
