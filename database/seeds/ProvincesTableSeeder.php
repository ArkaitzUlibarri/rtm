<?php

use Illuminate\Database\Seeder;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$provinces = [
			[ 'code' => 'ALB', 'name' => 'ALBACETE', 'zone' => 3 ],
			[ 'code' => 'A', 'name' => 'ALICANTE', 'zone' => 4 ],
			[ 'code' => 'AL', 'name' => 'ALMERIA', 'zone' => 4 ],
			[ 'code' => 'VI', 'name' => 'ARABA', 'zone' => 2 ],
			[ 'code' => 'AST', 'name' => 'ASTURIAS', 'zone' => 5 ],
			[ 'code' => 'AV', 'name' => 'AVILA', 'zone' => 1 ],
			[ 'code' => 'BA', 'name' => 'BADAJOZ', 'zone' => 4 ],
			[ 'code' => 'PM', 'name' => 'BALEARES', 'zone' => 4 ],
			[ 'code' => 'B', 'name' => 'BARCELONA', 'zone' => 4 ],
			[ 'code' => 'BI', 'name' => 'BIZKAIA', 'zone' => 2 ],
			[ 'code' => 'BU', 'name' => 'BURGOS', 'zone' => 5 ],
			[ 'code' => 'CAC', 'name' => 'CACERES', 'zone' => 4 ],
			[ 'code' => 'CA', 'name' => 'CADIZ', 'zone' => 4 ],
			[ 'code' => 'S', 'name' => 'CANTABRIA', 'zone' => 5 ],
			[ 'code' => 'CAS', 'name' => 'CASTELLON', 'zone' => 4 ],
			[ 'code' => 'CR', 'name' => 'CIUDAD-REAL', 'zone' => 1 ],
			[ 'code' => 'CO', 'name' => 'CORDOBA', 'zone' => 4 ],
			[ 'code' => 'C', 'name' => 'CORUÑA', 'zone' => 5 ],
			[ 'code' => 'CU', 'name' => 'CUENCA', 'zone' => 1 ],
			[ 'code' => 'SS', 'name' => 'GIPUZKOA', 'zone' => 2 ],
			[ 'code' => 'GE', 'name' => 'GERONA', 'zone' => 2 ],
			[ 'code' => 'GR', 'name' => 'GRANADA', 'zone' => 4 ],
			[ 'code' => 'GU', 'name' => 'GUADALAJARA', 'zone' => 1 ],
			[ 'code' => 'H', 'name' => 'HUELVA', 'zone' => 4 ],
			[ 'code' => 'HU', 'name' => 'HUESCA', 'zone' => 2 ],
			[ 'code' => 'J', 'name' => 'JAEN', 'zone' => 4 ],
			[ 'code' => 'LE', 'name' => 'LEON', 'zone' => 5 ],
			[ 'code' => 'L', 'name' => 'LERIDA', 'zone' => 2 ],
			[ 'code' => 'LU', 'name' => 'LUGO', 'zone' => 5 ],
			[ 'code' => 'M', 'name' => 'MADRID', 'zone' => 1 ],
			[ 'code' => 'MA', 'name' => 'MALAGA', 'zone' => 4 ],
			[ 'code' => 'MU', 'name' => 'MURCIA', 'zone' => 4 ],
			[ 'code' => 'NA', 'name' => 'NAVARRA', 'zone' => 2 ],
			[ 'code' => 'OU', 'name' => 'OURENSE', 'zone' => 5 ],
			[ 'code' => 'P', 'name' => 'PALENCIA', 'zone' => 5 ],
			[ 'code' => 'GC', 'name' => 'LAS PALMAS', 'zone' => 4 ],
			[ 'code' => 'PO', 'name' => 'PONTEVEDRA', 'zone' => 5 ],
			[ 'code' => 'LO', 'name' => 'LA RIOJA', 'zone' => 2 ],
			[ 'code' => 'SA', 'name' => 'SALAMANCA', 'zone' => 1 ],
			[ 'code' => 'TF', 'name' => 'TENERIFE', 'zone' => 4 ],
			[ 'code' => 'SG', 'name' => 'SEGOVIA', 'zone' => 1 ],
			[ 'code' => 'SE', 'name' => 'SEVILLA', 'zone' => 4 ],
			[ 'code' => 'SO', 'name' => 'SORIA', 'zone' => 1 ],
			[ 'code' => 'T', 'name' => 'TARRAGONA', 'zone' => 2 ],
			[ 'code' => 'TE', 'name' => 'TERUEL', 'zone' => 4 ],
			[ 'code' => 'TO', 'name' => 'TOLEDO', 'zone' => 1 ],
			[ 'code' => 'V', 'name' => 'VALENCIA', 'zone' => 4 ],
			[ 'code' => 'VA', 'name' => 'VALLADOLID', 'zone' => 5 ],
			[ 'code' => 'ZA', 'name' => 'ZAMORA', 'zone' => 5 ],
			[ 'code' => 'Z', 'name' => 'ZARAGOZA', 'zone' => 2 ],
			[ 'code' => 'CE', 'name' => 'CEUTA', 'zone' => 4 ],
			[ 'code' => 'ML', 'name' => 'MELILLA', 'zone' => 4 ]
		];

		foreach ($provinces as $province) {
			DB::table('provinces')->insert([
				'code' => $province['code'],
				'name' => $province['name'],
				'zone' => $province['zone'],
			]);
		}
    }
}
