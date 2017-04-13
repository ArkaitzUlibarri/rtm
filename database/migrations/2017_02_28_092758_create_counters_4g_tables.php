<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCounters4gTables extends Migration
{
	protected $tables = [
		'tmp_4g' => [
			'type'   => 'integer',
			'unique' => false
		],
		'counters_4g_rop' => [
			'type'   => 'integer',
			'unique' => true
		],
		'counters_4g_hour' => [
			'type'   => 'integer',
			'unique' => true
		],
		'counters_4g_day' => [
			'type'   => 'integer',
			'unique' => true
		],
		'counters_4g_province_rop' => [
			'type'   => 'biginteger',
			'unique' => true
		],
		'counters_4g_province_hour' => [
			'type'   => 'biginteger',
			'unique' => true
		],
		'counters_4g_province_day' => [
			'type'   => 'biginteger',
			'unique' => true
		],
	];

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		foreach ($this->tables as $tableName => $options) {

			$fieldType = $options['type'];
			
			Schema::create('eri.' . $tableName, function (Blueprint $table) use($fieldType) {
				$table->datetime('created_at');
				$table->integer('item_id');
				$table->$fieldType('c1')->nullable();
				$table->$fieldType('c2')->nullable();
				$table->$fieldType('c3')->nullable();
				$table->$fieldType('c4')->nullable();
				$table->$fieldType('c5')->nullable();
				$table->$fieldType('c6')->nullable();
				$table->$fieldType('c7')->nullable();
				$table->$fieldType('c8')->nullable();
				$table->$fieldType('c9')->nullable();
				$table->$fieldType('c10')->nullable();
				$table->$fieldType('c11')->nullable();
				$table->$fieldType('c12')->nullable();
				$table->$fieldType('c13')->nullable();
				$table->$fieldType('c14')->nullable();
				$table->$fieldType('c15')->nullable();
				$table->$fieldType('c16')->nullable();
				$table->$fieldType('c17')->nullable();
				$table->$fieldType('c18')->nullable();
				$table->$fieldType('c19')->nullable();
				$table->$fieldType('c20')->nullable();
				$table->$fieldType('c21')->nullable();
				$table->$fieldType('c22')->nullable();
				$table->$fieldType('c23')->nullable();
				$table->$fieldType('c24')->nullable();
				$table->$fieldType('c25')->nullable();
				$table->$fieldType('c26')->nullable();
				$table->$fieldType('c27')->nullable();
				$table->$fieldType('c28')->nullable();
				$table->$fieldType('c29')->nullable();
				$table->$fieldType('c30')->nullable();
				$table->$fieldType('c31')->nullable();
				$table->$fieldType('c32')->nullable();
				$table->$fieldType('c33')->nullable();
				$table->$fieldType('c34')->nullable();
				$table->$fieldType('c35')->nullable();
				$table->$fieldType('c36')->nullable();
				$table->$fieldType('c37')->nullable();
				$table->$fieldType('c38')->nullable();
				$table->$fieldType('c39')->nullable();
				$table->$fieldType('c40')->nullable();
				$table->$fieldType('c41')->nullable();
				$table->$fieldType('c42')->nullable();
				$table->$fieldType('c43')->nullable();
				$table->$fieldType('c44')->nullable();
				$table->$fieldType('c45')->nullable();
				$table->$fieldType('c46')->nullable();
				$table->$fieldType('c47')->nullable();
				$table->$fieldType('c48')->nullable();
				$table->$fieldType('c49')->nullable();
				$table->$fieldType('c50')->nullable();
				$table->$fieldType('c51')->nullable();
				$table->$fieldType('c52')->nullable();
				$table->$fieldType('c53')->nullable();
				$table->$fieldType('c54')->nullable();
				$table->$fieldType('c55')->nullable();
				$table->$fieldType('c56')->nullable();
				$table->$fieldType('c57')->nullable();
			});

			Schema::create('hua.' . $tableName, function (Blueprint $table) use($fieldType) {
				$table->datetime('created_at');
				$table->integer('item_id');
				$table->$fieldType('c1')->nullable();
				$table->$fieldType('c2')->nullable();
				$table->$fieldType('c3')->nullable();
				$table->$fieldType('c4')->nullable();
				$table->$fieldType('c5')->nullable();
				$table->$fieldType('c6')->nullable();
				$table->$fieldType('c7')->nullable();
				$table->$fieldType('c8')->nullable();
				$table->$fieldType('c9')->nullable();
				$table->$fieldType('c10')->nullable();
				$table->$fieldType('c11')->nullable();
				$table->$fieldType('c12')->nullable();
				$table->$fieldType('c13')->nullable();
				$table->$fieldType('c14')->nullable();
				$table->$fieldType('c15')->nullable();
				$table->$fieldType('c16')->nullable();
				$table->$fieldType('c17')->nullable();
				$table->$fieldType('c18')->nullable();
				$table->$fieldType('c19')->nullable();
				$table->$fieldType('c20')->nullable();
				$table->$fieldType('c21')->nullable();
				$table->$fieldType('c22')->nullable();
				$table->$fieldType('c23')->nullable();
				$table->$fieldType('c24')->nullable();
				$table->$fieldType('c25')->nullable();
				$table->$fieldType('c26')->nullable();
				$table->$fieldType('c27')->nullable();
				$table->$fieldType('c28')->nullable();
				$table->$fieldType('c29')->nullable();
				$table->$fieldType('c30')->nullable();
				$table->$fieldType('c31')->nullable();
				$table->$fieldType('c32')->nullable();
				$table->$fieldType('c33')->nullable();
				$table->$fieldType('c34')->nullable();
				$table->$fieldType('c35')->nullable();
				$table->$fieldType('c36')->nullable();
				$table->$fieldType('c37')->nullable();
				$table->$fieldType('c38')->nullable();
				$table->$fieldType('c39')->nullable();
				$table->$fieldType('c40')->nullable();
				$table->$fieldType('c41')->nullable();
				$table->$fieldType('c42')->nullable();
				$table->$fieldType('c43')->nullable();
				$table->$fieldType('c44')->nullable();
				$table->$fieldType('c45')->nullable();
				$table->$fieldType('c46')->nullable();
				$table->$fieldType('c47')->nullable();
				$table->$fieldType('c48')->nullable();
				$table->$fieldType('c49')->nullable();
				$table->$fieldType('c50')->nullable();
				$table->$fieldType('c51')->nullable();
				$table->$fieldType('c52')->nullable();
				$table->$fieldType('c53')->nullable();
			});

			if($options['unique']) {
				Schema::table('eri.' . $tableName, function($table)
				{
					$table->unique(['created_at', 'item_id']);
				});
			}

			if($options['unique']) {
				Schema::table('hua.' . $tableName, function($table)
				{
					$table->unique(['created_at', 'item_id']);
				});
			}
		}

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		foreach ($this->tables as $tableName => $options) {
			Schema::dropIfExists('eri.' . $tableName);
			Schema::dropIfExists('hua.' . $tableName);
		}
	}
}
