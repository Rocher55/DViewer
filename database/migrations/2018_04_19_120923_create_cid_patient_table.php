<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCidPatientTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cid_patient', function(Blueprint $table)
		{
			$table->integer('CID_ID')->index('fk_CidPatient_Cid');
			$table->integer('Patient_ID')->index('fk_CidPatient_Patient');
			$table->unique(['Patient_ID','CID_ID'], 'ind_cidPatient');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cid_patient');
	}

}
