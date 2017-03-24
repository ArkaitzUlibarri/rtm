<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NodesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$nodes = SeederConfig::NODES;

        for ($i=1; $i <= $nodes; $i++)
		{ 
			DB::table('nodes')->insert([
				'name' => 'NODE' . $i,
			]);
		}
    }
}
