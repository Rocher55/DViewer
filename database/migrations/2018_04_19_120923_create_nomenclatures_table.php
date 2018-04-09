<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNomenclaturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('nomenclatures', function(Blueprint $table)
		{
			$table->integer('Nomenclature_ID', true);
			$table->string('NameN')->nullable();
			$table->string('CDISC', 20)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('nomenclatures');
	}

}
