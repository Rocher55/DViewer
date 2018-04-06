<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEaAnalyseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ea_analyse', function(Blueprint $table)
		{
			$table->integer('Analyse_ID')->primary();
			$table->integer('CID_ID')->index('fk_Analyse_CID');
			$table->integer('Patient_ID');
			$table->integer('Molecule_ID')->nullable()->index('fk_Analyse_Molecule');
			$table->integer('SampleType_ID')->index('fk_Analyse_Sample');
			$table->integer('Technique_ID')->nullable()->index('fk_Analyse_Technique');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ea_analyse');
	}

}
