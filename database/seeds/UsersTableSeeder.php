<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		factory(App\User::class)->create([
			'name'  => 'Ivan Iglesias',
			'email' =>'ivan.iglesias@3dbconsult.com',
			'role'  => 'admin'
		]);

		factory(App\User::class)->create([
			'name'  => 'Arkaitz Ulibarri',
			'email' => 'arkaitz.ulibarri@3dbconsult.com',
			'role'  => 'admin'
		]);

		factory(App\User::class)->create([
			'name'  => 'Gaizka korta',
			'email' => 'gaizka.korta@3dbconsult.com',
			'role'  => 'admin'
		]);

		factory(App\User::class)->create([
			'name'  => 'Patricia Atanes',
			'email' => 'patricia.atanes@3dbconsult.com',
			'role'  => 'admin'
		]);

		factory(App\User::class, 50)->create();
	}
}
