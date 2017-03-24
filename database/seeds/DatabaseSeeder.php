<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	use SeederHelpers;

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$this->call(UsersTableSeeder::class);
		$this->call(FieldsTableSeeder::class);
		$this->call(ProvincesTableSeeder::class);
		$this->call(ControllersTableSeeder::class);
		$this->call(NodesTableSeeder::class);
		$this->call(CellsTableSeeder::class);
		$this->call(NodeAlarmsTableSeeder::class);
		$this->call(KpisTableSeeder::class);

		$this->call(CountersTableSeeder::class);
		$this->call(CounterControllersTableSeeder::class);
		$this->call(CounterProvincesTableSeeder::class);
		
	}
}
