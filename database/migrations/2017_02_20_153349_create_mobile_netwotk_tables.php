<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileNetwotkTables extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/**
		 * Provincias.
		 */
		Schema::create('provinces', function (Blueprint $table) {
			$table->increments('id');

			/*$table->integer('country_id')->unsigned();
			$table->foreign('country_id')
				  ->references('id')->on('countries')
				  ->onDelete('cascade');*/

			$table->string('code', 3)->unique();
			$table->string('name', 30);
			$table->tinyInteger('zone')->unsigned();

			//$table->unique(['country_id', 'code']);
		});

		/**
		 * Tabla con las BSCs y RNCs.
		 */
		Schema::create('controllers', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 30)->index();

			$table->integer('province_id')->unsigned();
			$table->foreign('province_id')
				  ->references('id')->on('provinces')
				  ->onDelete('cascade');

			$table->enum('vendor', ['eri', 'hua']);
			$table->enum('tech', ['2g', '3g']);
		});

		/**
		 * Nodos de las tres tecnologias.
		 */
		Schema::create('nodes', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 30)->index();
		});

		/**
		 * Celdas de las tres tecnologias.
		 */
		Schema::create('cells', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name', 30)->index();

			$table->enum('vendor', ['eri', 'hua']);
			$table->enum('tech', ['2g', '3g', '4g']);

			$table->integer('node_id')->nullable()->unsigned();
			$table->foreign('node_id')
				  ->references('id')->on('nodes')
				  ->onDelete('cascade');
			
			$table->integer('controller_id')->nullable()->unsigned();
			$table->foreign('controller_id')
				  ->references('id')->on('controllers')
				  ->onDelete('cascade');

			$table->integer('province_id')->unsigned();
			$table->foreign('province_id')
				  ->references('id')->on('provinces')
				  ->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('cells');
		Schema::dropIfExists('nodes');
		Schema::dropIfExists('controllers');
		Schema::dropIfExists('provinces');
	}
}
