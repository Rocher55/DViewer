<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFoodDiariesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('food_diaries', function(Blueprint $table)
		{
			$table->integer('food_diaries_ID', true);
			$table->integer('WK_ID');
			$table->integer('Patient_ID');
			$table->integer('NB_Days')->nullable();
			$table->float('Valeur', 10, 0)->nullable();
			$table->integer('Nomenclature_ID');
			$table->integer('Unite_Mesure_ID');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('food_diaries');
	}

}
