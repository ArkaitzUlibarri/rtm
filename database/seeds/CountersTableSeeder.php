<?php

use Illuminate\Database\Seeder;

class CountersTableSeeder extends Seeder
{
	use SeederHelpers;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$start = SeederConfig::START_DATE();		// Fecha inicio
		$end = SeederConfig::END_DATE();			// Fecha fin
		$batchSize = SeederConfig::BATCH_SIZE;		// Registros a insertar por transaccion
		$fields = config('countersfields');			// Array con los campos por vendor y tecnología
		$technologies = SeederConfig::TECHNOLOGIES;	// Tecnologias a procesar
		$valuesBy = SeederConfig::COUNTER_VALUES;	// Valores por defecto para asignar a los contadores

		foreach ($technologies as $tech) {
			$cells = DB::table('cells')->where('tech', $tech)->select('id', 'vendor')->get();
			$now = $start->copy();

			// Recorro las fechas+horas
			while ($now <= $end)
			{
				$data_eri = array();
				$data_hua = array();
				$counter = $batchSize;

				// Recorro las celdas
				foreach($cells as $cell)
				{
					$data = $this->makeEntry(
						$cell->id,
						$now->toDateTimeString(),
						count($fields[$cell->vendor][$tech]),
						$valuesBy[$cell->vendor][$tech]
					);
			
					if($cell->vendor == 'eri') {
						$data_eri[] = $data;
					}
					else {
						$data_hua[] = $data;
					}

					$counter--;

					if($counter == 0 && $tech != '2g') {
						DB::table('eri.counters_' . $tech . '_rop')->insert($data_eri);
						DB::table('hua.counters_' . $tech . '_rop')->insert($data_hua);
						$data_eri = array();
						$data_hua = array();
						$counter = $batchSize;
					}

					if($now->minute == '00') {
						if($now->hour == '12') {
							DB::table($cell->vendor  . '.counters_' . $tech . '_day')->insert($data);
						}

						DB::table($cell->vendor . '.counters_' . $tech . '_hour')->insert($data);
					}
				}

				if($counter > 0 && $counter < $batchSize && $tech != '2g') {
					DB::table('eri.counters_' . $tech . '_rop')->insert($data_eri);
					DB::table('hua.counters_' . $tech . '_rop')->insert($data_hua);
					$data_eri = array();
					$data_hua = array();
				}

				$now->addMinutes(15);
			}
		}
	}
}
