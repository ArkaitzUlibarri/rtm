<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KpisTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$faker = Faker::create();

		$kpis = [
			[
				'tech'               => '2g',
				'vendor'             => 'eri',
				'name'               => 'partial_eri_2g_1',
				'type'               => 'prt',
				'equation'           => 'c1',
			],
			[
				'tech'               => '2g',
				'vendor'             => 'eri',
				'name'               => 'partial_eri_2g_2',
				'type'               => 'prt',
				'equation'           => 'c3+c5',
			],
			[
				'tech'               => '2g',
				'vendor'             => 'eri',
				'name'               => 'partial_eri_2g_3',
				'type'               => 'prt',
				'equation'           => 'c1*2',
			],
			[
				'tech'               => '3g',
				'vendor'             => 'eri',
				'name'               => 'partial_eri_3g_1',
				'type'               => 'prt',
				'equation'           => 'c1+c9',
			],
			[
				'tech'               => '3g',
				'vendor'             => 'eri',
				'name'               => 'partial_eri_3g_2',
				'type'               => 'prt',
				'equation'           => 'c5*2',
			],
			[
				'tech'               => '4g',
				'vendor'             => 'eri',
				'name'               => 'partial_eri_4g_1',
				'type'               => 'prt',
				'equation'           => 'c10+c5',
			],
			[
				'tech'               => '4g',
				'vendor'             => 'eri',
				'name'               => 'partial_eri_4g_2',
				'type'               => 'prt',
				'equation'           => 'c1*10',
			],
			[
				'tech'               => '2g',
				'vendor'             => 'hua',
				'name'               => 'partial_hua_2g_1',
				'type'               => 'prt',
				'equation'           => 'c1*2',
			],
			[
				'tech'               => '3g',
				'vendor'             => 'hua',
				'name'               => 'partial_hua_3g_1',
				'type'               => 'prt',
				'equation'           => 'c1+c2',
			],
			[
				'tech'               => '4g',
				'vendor'             => 'hua',
				'name'               => 'partial_hua_4g_1',
				'type'               => 'prt',
				'equation'           => 'c1+c2+c3',
			],

			// ****************************************************
			// ****************************************************
			[
				'tech'               => null,
				'vendor'             => 'eri',
				'name'               => 'dual_eri_2g_3g_1',
				'type'               => 'tech',
				'equation'           => 'p1+p4',
			],
			[
				'tech'               => null,
				'vendor'             => 'eri',
				'name'               => 'dual_eri_2g_3g_2',
				'type'               => 'tech',
				'equation'           => 'p2*+p5',
			],
			[
				'tech'               => null,
				'vendor'             => 'eri',
				'name'               => 'dual_eri_3g_4g_1',
				'type'               => 'tech',
				'equation'           => 'p4+p6',
			],
			[
				'tech'               => null,
				'vendor'             => 'hua',
				'name'               => 'dual_hua_2g_3g_1',
				'type'               => 'tech',
				'equation'           => 'p8+p9',
			],
			[
				'tech'               => null,
				'vendor'             => 'eri',
				'name'               => 'multi_eri_1',
				'type'               => 'tech',
				'equation'           => 'p1+p4+p6',
			],
			[
				'tech'               => null,
				'vendor'             => 'hua',
				'name'               => 'multi_hua_1',
				'type'               => 'tech',
				'equation'           => 'p8+p9+p10',
			],
			[
				'tech'               => '2g',
				'vendor'             => null,
				'name'               => 'vendor_2g',
				'type'               => 'vnd',
				'equation'           => '100*(p1+p8)/(p2)',
			],
			[
				'tech'               => '3g',
				'vendor'             => null,
				'name'               => 'vendor_3g',
				'type'               => 'vnd',
				'equation'           => 'p4+p9/p5',
			],
			[
				'tech'               => '4g',
				'vendor'             => null,
				'name'               => 'vendor_4g',
				'type'               => 'vnd',
				'equation'           => 'p6+p10',
			],

			// ****************************************************
			// ****************************************************
			[
				'tech'               => '2g',
				'vendor'             => 'eri',
				'name'               => 'cssr_cs',
				'type'               => 'std',
				'equation'           => 'c1+p2',
			],
			[
				'tech'               => '2g',
				'vendor'             => 'eri',
				'name'               => 'cdr',
				'type'               => 'std',
				'equation'           => 'c15+(3*c2)-c7',
			],
			[
				'tech'               => '2g',
				'vendor'             => 'eri',
				'name'               => 'sd_drop',
				'type'               => 'std',
				'equation'           => '2*(c3+c1)',
			],
			[
				'tech'               => '2g',
				'vendor'             => 'eri',
				'name'               => 'calls',
				'type'               => 'std',
				'equation'           => '(3*c32-c70)+c50',
			],
			[
				'tech'               => '2g',
				'vendor'             => 'hua',
				'name'               => 'cdr',
				'type'               => 'std',
				'equation'           => 'c1*2',
			],
			[
				'tech'               => '2g',
				'vendor'             => 'hua',
				'name'               => 'tch_block',
				'type'               => 'std',
				'equation'           => 'c15+(2*c2)-c7',
			],
			[
				'tech'               => '2g',
				'vendor'             => 'hua',
				'name'               => 'th',
				'type'               => 'std',
				'equation'           => 'c15+(3*c10)-c7',
			],
			[
				'tech'               => '3g',
				'vendor'             => 'eri',
				'name'               => 'tch_block',
				'type'               => 'std',
				'equation'           => 'c1+c50',
			],
			[
				'tech'               => '3g',
				'vendor'             => 'eri',
				'name'               => 'cdr',
				'type'               => 'std',
				'equation'           => 'c15+(3*c2)-c7',
			],
			[
				'tech'               => '3g',
				'vendor'             => 'hua',
				'name'               => 'th',
				'type'               => 'std',
				'equation'           => 'c15+(3*c10)-c7',
			],
			[
				'tech'               => '4g',
				'vendor'             => 'eri',
				'name'               => 'tch_block',
				'type'               => 'std',
				'equation'           => 'c1+c33',
			],
			[
				'tech'               => '4g',
				'vendor'             => 'eri',
				'name'               => 'cdr',
				'type'               => 'std',
				'equation'           => 'c15+(3*c2)-c7',
			],

		];


		foreach ($kpis as $kpi)
		{
			$thresholdRed = $faker->randomFloat(0, 70, 85);
			$thresholdYellow = $thresholdRed - $faker->randomFloat(0, 5, 15);
			$thresholdRedAggregate = $thresholdRed + 10;
			$thresholdYellowAggregate = $thresholdYellow + 10;

			if($kpi["type"] == 'std' && $faker->boolean(50)) {
				$relative = true;
				$absolute = true;		
			}
			else {
				$relative = false;
				$absolute = false;
			}

			DB::table('kpis')->insert([
				'tech'                             => $kpi["tech"],
				'vendor'                           => $kpi["vendor"],
				'name'                             => $kpi["name"],
				'type'                             => $kpi["type"],
				'equation'                         => $kpi["equation"],
				
				'symbol_red'                       => $kpi["type"] != 'prt' ? '<=' : null,
				'threshold_red'                    => $kpi["type"] != 'prt' ? $thresholdRed : null,
				'threshold_aggregate_red'          => $kpi["type"] != 'prt' ? $thresholdRedAggregate : null,
				
				'symbol_yellow'                    => $kpi["type"] != 'prt' ? '<' : null,
				'threshold_yellow'                 => $kpi["type"] != 'prt' ? $thresholdYellow : null,			
				'threshold_aggregate_yellow'       => $kpi["type"] != 'prt' ? $thresholdYellowAggregate : null,
				
				'threshold_relative'               => $relative ? $thresholdRed : null,
				'threshold_relative_n'             => $relative ? $faker->numberBetween(2, 6) : null,
				'threshold_relative_condition'     => null,
				'threshold_relative_condition_kpi' => null,
				'threshold_aggregate_relative'     => $relative ? $thresholdRed : null,
				'threshold_aggregate_relative_n'   => $relative ? $faker->numberBetween(2, 6) : null,
				
				'threshold_aggregate_absolute'     => $absolute ? $thresholdRed : null,
				'threshold_aggregate_absolute_n'   => $absolute ? $faker->numberBetween(2, 6) : null,
			]);
		}
	}
}
