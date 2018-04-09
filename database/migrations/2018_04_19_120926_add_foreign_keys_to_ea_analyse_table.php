<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToEaAnalyseTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('ea_analyse', function(Blueprint $table)
		{
			$table->foreign('Molecule_ID', 'fk_Analyse_Molecule	')->references('Molecule_ID')->on('molecules')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('SampleType_ID', 'fk_Analyse_Sample')->references('SampleType_ID')->on('sampletypes')->onUpdate('RESTRICT')->onDelete('CASCADE');
			$table->foreign('Technique_ID', 'fk_Analyse_Technique')->references('Technique_ID')->on('techniques')->onUpdate('RESTRICT')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('ea_analyse', function(Blueprint $table)
		{
			$table->dropForeign('fk_Analyse_Molecule	');
			$table->dropForeign('fk_Analyse_Sample');
			$table->dropForeign('fk_Analyse_Technique');
		});
	}

}
