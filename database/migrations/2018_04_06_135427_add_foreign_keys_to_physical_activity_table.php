<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPhysicalActivityTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('physical_activity', function(Blueprint $table)
		{
			$table->foreign('Patient_ID', 'fk_PA_CidPatient')->references('Patient_ID')->on('cid_patient')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('Cid_ID', 'fk_PA_CidPatientCID')->references('CID_ID')->on('cid_patient')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('physical_activity', function(Blueprint $table)
		{
			$table->dropForeign('fk_PA_CidPatient');
			$table->dropForeign('fk_PA_CidPatientCID');
		});
	}

}
