<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigurationTables extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		Schema::create('kpis', function (Blueprint $table) {
			$table->increments('id');
			$table->enum('vendor', ['eri', 'hua'])->nullable();
			$table->enum('tech', ['2g', '3g', '4g'])->nullable();
			$table->string('name', 50);
			$table->enum('type', ['std', 'tech', 'vnd', 'prt']);
			$table->enum('symbol_red', ['==', '!=', '<', '>', '<=', '>='])->nullable();
			$table->decimal('threshold_red', 10, 2)->nullable();
			$table->decimal('threshold_aggregate_red', 10, 2)->nullable();
			$table->enum('symbol_yellow', ['==', '!=', '<', '>', '<=', '>='])->nullable();
			$table->decimal('threshold_yellow', 10, 2)->nullable();
			$table->decimal('threshold_aggregate_yellow', 10, 2)->nullable();
			$table->decimal('threshold_relative', 10, 2)->nullable();
			$table->tinyinteger('threshold_relative_n')->nullable();
			$table->decimal('threshold_relative_condition', 10, 2)->nullable();
			$table->integer('threshold_relative_condition_kpi')->nullable();
			$table->decimal('threshold_aggregate_relative', 10, 2)->nullable();
			$table->tinyinteger('threshold_aggregate_relative_n')->nullable();
			$table->decimal('threshold_aggregate_absolute', 10, 2)->nullable();
			$table->tinyinteger('threshold_aggregate_absolute_n')->nullable();

			$table->string('equation');
			$table->unique(['tech', 'vendor', 'name', 'type']);
		});


		Schema::create('fields', function (Blueprint $table) {
			$table->increments('id');
			$table->enum('tech', ['2g', '3g', '4g']);
			$table->enum('vendor', ['eri', 'hua']);
			$table->string('db_name');
			$table->string('oss_name');
			$table->unique(['tech', 'vendor', 'oss_name']);
		});


		Schema::create('batch', function (Blueprint $table) {
			$table->increments('id');
			$table->dateTime('created_at');
			$table->enum('vendor', ['eri', 'hua']);
			$table->enum('tech', ['2g', '3g', '4g']);
			$table->boolean('counter_aggregate')->default(false);
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('kpis');
		Schema::dropIfExists('fields');
		Schema::dropIfExists('batch');
	}
}
