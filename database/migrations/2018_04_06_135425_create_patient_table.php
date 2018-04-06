<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePatientTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('patient', function(Blueprint $table)
		{
			$table->integer('Patient_ID', true);
			$table->string('SUBJID', 10);
			$table->string('SUBJINIT', 10)->nullable();
			$table->integer('Protocol_ID')->index('fk_Patient_Protocol');
			$table->integer('Center_ID')->index('fk_Patient_Center');
			$table->string('Class', 10)->nullable();
			$table->integer('Sex');
			$table->integer('Age')->nullable();
			$table->float('Height (m)', 10, 0)->nullable();
			$table->date('Birth_Date')->nullable();
			$table->string('Race', 3)->nullable();
			$table->integer('Family_ID')->nullable();
			$table->integer('Family_Structure')->nullable();
			$table->integer('Female premenopausal')->nullable();
			$table->string('Female use Oral contraceptives', 50)->nullable();
			$table->string('Type_Contraceptive', 50)->nullable();
			$table->string('Mother urine pregnant', 3)->nullable();
			$table->integer('Parents eligible for inclusion')->nullable();
			$table->integer('Eating disorder')->nullable();
			$table->string('Eating disorder comment', 100)->nullable();
			$table->string('Alcohol or drug abuse', 3)->nullable();
			$table->integer('Drink alcohol')->nullable();
			$table->integer('Alcohol(WK)')->nullable();
			$table->string('Concomitant condition', 4)->nullable();
			$table->integer('Cigarettes-Pipes/year')->nullable();
			$table->integer('EER')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('patient');
	}

}
