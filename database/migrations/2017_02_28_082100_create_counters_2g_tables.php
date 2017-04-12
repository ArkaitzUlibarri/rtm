<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCounters2gTables extends Migration
{
	protected $tables = [
		'tmp_2g' => [
			'type'   => 'integer',
			'unique' => false
		],
		'counters_2g_hour' => [
			'type'   => 'integer',
			'unique' => true
		],
		'counters_2g_day' => [
			'type'   => 'integer',
			'unique' => true
		],
		'counters_2g_controller_hour' => [
			'type'   => 'biginteger',
			'unique' => true
		],
		'counters_2g_controller_day' => [
			'type'   => 'biginteger',
			'unique' => true
		],
		'counters_2g_province_hour' => [
			'type'   => 'biginteger',
			'unique' => true
		],
		'counters_2g_province_day' => [
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
		foreach ($this->tables as $table => $options) {

			Schema::create('eri.' . $table, function (Blueprint $table) use($options) {
				$table->datetime('created_at');
				$table->integer('item_id');
				$table->$options['type']('c1')->nullable();
				$table->$options['type']('c2')->nullable();
				$table->$options['type']('c3')->nullable();
				$table->$options['type']('c4')->nullable();
				$table->$options['type']('c5')->nullable();
				$table->$options['type']('c6')->nullable();
				$table->$options['type']('c7')->nullable();
				$table->$options['type']('c8')->nullable();
				$table->$options['type']('c9')->nullable();
				$table->$options['type']('c10')->nullable();
				$table->$options['type']('c11')->nullable();
				$table->$options['type']('c12')->nullable();
				$table->$options['type']('c13')->nullable();
				$table->$options['type']('c14')->nullable();
				$table->$options['type']('c15')->nullable();
				$table->$options['type']('c16')->nullable();
				$table->$options['type']('c17')->nullable();
				$table->$options['type']('c18')->nullable();
				$table->$options['type']('c19')->nullable();
				$table->$options['type']('c20')->nullable();
				$table->$options['type']('c21')->nullable();
				$table->$options['type']('c22')->nullable();
				$table->$options['type']('c23')->nullable();
				$table->$options['type']('c24')->nullable();
				$table->$options['type']('c25')->nullable();
				$table->$options['type']('c26')->nullable();
				$table->$options['type']('c27')->nullable();
				$table->$options['type']('c28')->nullable();
				$table->$options['type']('c29')->nullable();
				$table->$options['type']('c30')->nullable();
				$table->$options['type']('c31')->nullable();
				$table->$options['type']('c32')->nullable();
				$table->$options['type']('c33')->nullable();
				$table->$options['type']('c34')->nullable();
				$table->$options['type']('c35')->nullable();
				$table->$options['type']('c36')->nullable();
				$table->$options['type']('c37')->nullable();
				$table->$options['type']('c38')->nullable();
				$table->$options['type']('c39')->nullable();
				$table->$options['type']('c40')->nullable();
				$table->$options['type']('c41')->nullable();
				$table->$options['type']('c42')->nullable();
				$table->$options['type']('c43')->nullable();
				$table->$options['type']('c44')->nullable();
				$table->$options['type']('c45')->nullable();
				$table->$options['type']('c46')->nullable();
				$table->$options['type']('c47')->nullable();
				$table->$options['type']('c48')->nullable();
				$table->$options['type']('c49')->nullable();
				$table->$options['type']('c50')->nullable();
				$table->$options['type']('c51')->nullable();
				$table->$options['type']('c52')->nullable();
				$table->$options['type']('c53')->nullable();
				$table->$options['type']('c54')->nullable();
				$table->$options['type']('c55')->nullable();
				$table->$options['type']('c56')->nullable();
				$table->$options['type']('c57')->nullable();
				$table->$options['type']('c58')->nullable();
				$table->$options['type']('c59')->nullable();
				$table->$options['type']('c60')->nullable();
				$table->$options['type']('c61')->nullable();
				$table->$options['type']('c62')->nullable();
				$table->$options['type']('c63')->nullable();
				$table->$options['type']('c64')->nullable();
				$table->$options['type']('c65')->nullable();
				$table->$options['type']('c66')->nullable();
				$table->$options['type']('c67')->nullable();
				$table->$options['type']('c68')->nullable();
				$table->$options['type']('c69')->nullable();
				$table->$options['type']('c70')->nullable();
				$table->$options['type']('c71')->nullable();
				$table->$options['type']('c72')->nullable();
				$table->$options['type']('c73')->nullable();
				$table->$options['type']('c74')->nullable();
				$table->$options['type']('c75')->nullable();
				$table->$options['type']('c76')->nullable();
				$table->$options['type']('c77')->nullable();
				$table->$options['type']('c78')->nullable();
				$table->$options['type']('c79')->nullable();
				$table->$options['type']('c80')->nullable();
				$table->$options['type']('c81')->nullable();
				$table->$options['type']('c82')->nullable();
				$table->$options['type']('c83')->nullable();
				$table->$options['type']('c84')->nullable();
				$table->$options['type']('c85')->nullable();
				$table->$options['type']('c86')->nullable();
				$table->$options['type']('c87')->nullable();
				$table->$options['type']('c88')->nullable();
				$table->$options['type']('c89')->nullable();
			});

			Schema::create('hua.' . $table, function (Blueprint $table) use($options) {
				$table->datetime('created_at')->nullable();
				$table->integer('item_id')->nullable();
				$table->$options['type']('c1')->nullable();
				$table->$options['type']('c2')->nullable();
				$table->$options['type']('c3')->nullable();
				$table->$options['type']('c4')->nullable();
				$table->$options['type']('c5')->nullable();
				$table->$options['type']('c6')->nullable();
				$table->$options['type']('c7')->nullable();
				$table->$options['type']('c8')->nullable();
				$table->$options['type']('c9')->nullable();
				$table->$options['type']('c10')->nullable();
				$table->$options['type']('c11')->nullable();
				$table->$options['type']('c12')->nullable();
				$table->$options['type']('c13')->nullable();
				$table->$options['type']('c14')->nullable();
				$table->$options['type']('c15')->nullable();
				$table->$options['type']('c16')->nullable();
				$table->$options['type']('c17')->nullable();
				$table->$options['type']('c18')->nullable();
				$table->$options['type']('c19')->nullable();
				$table->$options['type']('c20')->nullable();
				$table->$options['type']('c21')->nullable();
				$table->$options['type']('c22')->nullable();
				$table->$options['type']('c23')->nullable();
				$table->$options['type']('c24')->nullable();
				$table->$options['type']('c25')->nullable();
				$table->$options['type']('c26')->nullable();
				$table->$options['type']('c27')->nullable();
				$table->$options['type']('c28')->nullable();
				$table->$options['type']('c29')->nullable();
				$table->$options['type']('c30')->nullable();
				$table->$options['type']('c31')->nullable();
				$table->$options['type']('c32')->nullable();
				$table->$options['type']('c33')->nullable();
				$table->$options['type']('c34')->nullable();
				$table->$options['type']('c35')->nullable();
				$table->$options['type']('c36')->nullable();
				$table->$options['type']('c37')->nullable();
				$table->$options['type']('c38')->nullable();
				$table->$options['type']('c39')->nullable();
				$table->$options['type']('c40')->nullable();
				$table->$options['type']('c41')->nullable();
				$table->$options['type']('c42')->nullable();
				$table->$options['type']('c43')->nullable();
				$table->$options['type']('c44')->nullable();
				$table->$options['type']('c45')->nullable();
				$table->$options['type']('c46')->nullable();
				$table->$options['type']('c47')->nullable();
				$table->$options['type']('c48')->nullable();
				$table->$options['type']('c49')->nullable();
				$table->$options['type']('c50')->nullable();
				$table->$options['type']('c51')->nullable();
				$table->$options['type']('c52')->nullable();
				$table->$options['type']('c53')->nullable();
				$table->$options['type']('c54')->nullable();
				$table->$options['type']('c55')->nullable();
				$table->$options['type']('c56')->nullable();
				$table->$options['type']('c57')->nullable();
				$table->$options['type']('c58')->nullable();
				$table->$options['type']('c59')->nullable();
				$table->$options['type']('c60')->nullable();
				$table->$options['type']('c61')->nullable();
				$table->$options['type']('c62')->nullable();
				$table->$options['type']('c63')->nullable();
				$table->$options['type']('c64')->nullable();
				$table->$options['type']('c65')->nullable();
				$table->$options['type']('c66')->nullable();
				$table->$options['type']('c67')->nullable();
				$table->$options['type']('c68')->nullable();
				$table->$options['type']('c69')->nullable();
				$table->$options['type']('c70')->nullable();
				$table->$options['type']('c71')->nullable();
				$table->$options['type']('c72')->nullable();
				$table->$options['type']('c73')->nullable();
				$table->$options['type']('c74')->nullable();
				$table->$options['type']('c75')->nullable();
				$table->$options['type']('c76')->nullable();
				$table->$options['type']('c77')->nullable();
				$table->$options['type']('c78')->nullable();
				$table->$options['type']('c79')->nullable();
				$table->$options['type']('c80')->nullable();
				$table->$options['type']('c81')->nullable();
			});

			if($options['unique']) {
				Schema::table('eri.' . $table, function($table)
				{
					$table->unique(['created_at', 'item_id']);
				});
			}

			if($options['unique']) {
				Schema::table('hua.' . $table, function($table)
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
		foreach ($this->tables as $table => $options) {
			Schema::dropIfExists('eri.' . $table);
			Schema::dropIfExists('hua.' . $table);
		}
	}
}
