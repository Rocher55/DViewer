<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPatientTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('patient', function(Blueprint $table)
		{
			$table->foreign('Center_ID', 'fk_PatientCentID_CenterProtocol')->references('Center_ID')->on('center_protocol')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('Protocol_ID', 'fk_PatientProID_CenterProtocol')->references('Protocol_ID')->on('center_protocol')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('patient', function(Blueprint $table)
		{
			$table->dropForeign('fk_PatientCentID_CenterProtocol');
			$table->dropForeign('fk_PatientProID_CenterProtocol');
		});
	}

}
