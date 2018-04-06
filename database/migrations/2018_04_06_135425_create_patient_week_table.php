<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePatientWeekTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patient_week', function(Blueprint $table)
		{
			$table->integer('WK_ID')->index('fk_PatientWK_Week');
			$table->integer('Patient_ID')->index('fk_PatientWK_Patient');
			$table->unique(['Patient_ID','WK_ID'], 'ind_Patient_Week');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('patient_week');
	}

}
