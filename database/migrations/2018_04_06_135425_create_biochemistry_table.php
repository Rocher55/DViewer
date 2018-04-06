<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBiochemistryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('biochemistry', function(Blueprint $table)
		{
			$table->integer('biochemistry_ID', true);
			$table->integer('CID_ID')->index('fk_cidpatient_cidid');
			$table->integer('Patient_ID')->index('fk_cidpatient_patientid');
			$table->date('Date_Bio')->nullable();
			$table->float('Valeur', 10, 0)->nullable();
			$table->integer('Nomenclature_ID')->index('fk_nomenclature_nomenclatureID');
			$table->integer('Unite_Mesure_ID')->index('fk_unitemesure_unitemesureID');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('biochemistry');
	}

}
