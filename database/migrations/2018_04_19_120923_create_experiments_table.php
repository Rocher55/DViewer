<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExperimentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('experiments', function(Blueprint $table)
		{
			$table->integer('Analyse_ID');
			$table->string('Gene_Symbol', 50)->index('fk_Experiment_Gene');
			$table->string('Probe_ID', 30)->index('fk_experiment_Gene_ProbeID');
			$table->float('value1', 10, 0)->nullable();
			$table->float('value2', 10, 0)->nullable();
			$table->unique(['Analyse_ID','Gene_Symbol','Probe_ID'], 'index_experiment');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('experiments');
	}

}
