<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCenterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('center', function(Blueprint $table)
		{
			$table->integer('Center_ID', true);
			$table->integer('Site_ID');
			$table->string('Center_Acronym', 8);
			$table->string('Center_City', 50)->nullable();
			$table->string('Center_Country', 50)->nullable();
			$table->string('Country_Acronym', 3)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('center');
	}

}
