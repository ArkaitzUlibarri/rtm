<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CounterProvincesTableSeeder extends Seeder
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
		$provinces = $this->getProvinces();

		foreach ($technologies as $tech) {
			$now = $start->copy();

			// Recorro las fechas+horas
			while ($now <= $end)
			{
				$data_eri = array();
				$data_hua = array();
				$counter = $batchSize;

				foreach($provinces as $province)
				{
					$data = $this->makeEntry(
						$province->id,
						$now->toDateTimeString(),
						count($fields[$province->vendor][$tech]),
						$valuesBy[$province->vendor][$tech]
					);

					if($province->vendor == 'eri') {
						$data_eri[] = $data;
					}
					else {
						$data_hua[] = $data;
					}

					$counter--;

					if($counter == 0 && $tech != '2g') {
						DB::table('eri.counters_' . $tech . '_province_rop')->insert($data_eri);
						DB::table('hua.counters_' . $tech . '_province_rop')->insert($data_hua);
						$data_eri = array();
						$data_hua = array();
						$counter = $batchSize;
					}

					if($now->minute == '00') {
						if($now->hour == '12') {
							DB::table($province->vendor  . '.counters_' . $tech . '_province_day')->insert($data);
						}

						DB::table($province->vendor . '.counters_' . $tech . '_province_hour')->insert($data);
					}

				}

				if($counter > 0 && $counter < $batchSize && $tech != '2g') {
					DB::table('eri.counters_' . $tech . '_province_rop')->insert($data_eri);
					DB::table('hua.counters_' . $tech . '_province_rop')->insert($data_hua);
					$data_eri = array();
					$data_hua = array();
				}

				$now->addMinutes(15);
			}
		}
    }

	private function getProvinces() {
		$response = array();
		$ids = $this->provinces();
		$vendors = ['eri', 'hua'];

		foreach ($ids as $id) {
			foreach ($vendors as $vendor) {
				$object = new stdClass();
				$object->id = $id;
				$object->vendor = $vendor;
				$response[] = $object;
			}
		}
		return $response;
	}
}
