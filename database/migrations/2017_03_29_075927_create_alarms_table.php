<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlarmsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/**
		 * Alarmas procesadas periodicamente por el servidor.
		 */
 		Schema::create('alarms', function (Blueprint $table) {
			$table->increments('id');
			$table->enum('type', ['traffic_loss', 'sleeping_cell', 'relative', 'absolute']);
			$table->datetime('created_at');
			$table->enum('vendor', ['eri', 'hua']);
			$table->enum('tech', ['2g', '3g', '4g']);
			$table->integer('controller_id')->unsigned();
			$table->integer('cell_id')->nullable()->unsigned();
			$table->integer('kpi_id')->unsigned();
			$table->decimal('value', 10, 2);
			$table->decimal('relative_threshold', 10, 2)->nullable();
			$table->decimal('threshold', 10, 2)->nullable();
			$table->tinyinteger('samples');

			$table->foreign('cell_id')
				  ->references('id')->on('cells')
				  ->onDelete('cascade');

			$table->foreign('kpi_id')
				  ->references('id')->on('kpis')
				  ->onDelete('cascade');


		});

		/**
		 * Alarmas de nodos extraidos del OSS.
		 */
		Schema::create('node_alarms', function (Blueprint $table) {
			$table->increments('id');
			// $table->enum('tech', ['2g', '3g', 'gG']);

			$table->integer('node_id')->unsigned()->index();
			$table->foreign('node_id')
				  ->references('id')->on('nodes')
				  ->onDelete('cascade');

			$table->dateTime('created_at');
			$table->string('sever');
			$table->string('specific_problem');
			$table->mediumtext('mo');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('node_alarms');
		Schema::dropIfExists('alarms');
	}
}
