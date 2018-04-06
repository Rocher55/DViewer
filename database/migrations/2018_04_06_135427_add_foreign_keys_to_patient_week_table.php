<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToPatientWeekTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('patient_week', function(Blueprint $table)
		{
			$table->foreign('Patient_ID', 'fk_PW_Patient')->references('Patient_ID')->on('patient')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('WK_ID', 'fk_PW_Week')->references('WK_ID')->on('week')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('patient_week', function(Blueprint $table)
		{
			$table->dropForeign('fk_PW_Patient');
			$table->dropForeign('fk_PW_Week');
		});
	}

}
