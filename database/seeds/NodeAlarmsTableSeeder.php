<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NodeAlarmsTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker::create();

		$sever = ['min', 'maj', 'crit'];
		$specificProblem = [
			'Emergency Unlock of Software Licensi',
			'External Link Failure',
			'GracePeriodStarted',
			'License Key File Fault',
			'Resource Allocation Failure Service'
		];

		$nodes = DB::table('nodes')->select('id')->get();

		foreach ($nodes as $node)
		{
			$numberAlarms = $faker->numberBetween(0, 4);

			for ($i=0; $i < $numberAlarms; $i++) 
			{
				DB::table('node_alarms')->insert([
					'node_id'          => $node->id,
					'created_at'       => $faker->dateTimeBetween('-1 years', 'now'),
					'sever'            => $faker->randomElement($sever),
					'specific_problem' => $faker->randomElement($specificProblem),
					'mo'               => $faker->sentence($nbWords = 6, $variableNbWords = true)
				]);
			}
		}
	}
}
