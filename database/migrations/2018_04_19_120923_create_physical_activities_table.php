<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePhysicalActivitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('physical_activities', function(Blueprint $table)
		{
			$table->integer('Cid_ID');
			$table->integer('Patient_ID')->index('fk_PA_CidPatient');
			$table->float('Baecke Work', 10, 0)->nullable();
			$table->float('Baecke Sport', 10, 0)->nullable();
			$table->float('Baecke Leisure', 10, 0)->nullable();
			$table->float('Baecke index total', 10, 0)->nullable();
			$table->unique(['Cid_ID','Patient_ID'], 'ind_PhysicalActivity');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('physical_activities');
	}

}
