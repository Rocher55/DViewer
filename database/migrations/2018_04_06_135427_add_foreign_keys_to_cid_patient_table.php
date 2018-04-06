<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCidPatientTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cid_patient', function(Blueprint $table)
		{
			$table->foreign('CID_ID', 'fk_CIDPatient_CID')->references('CID_ID')->on('cid')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('Patient_ID', 'fk_CIDPatient_Patient')->references('Patient_ID')->on('patient')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cid_patient', function(Blueprint $table)
		{
			$table->dropForeign('fk_CIDPatient_CID');
			$table->dropForeign('fk_CIDPatient_Patient');
		});
	}

}
