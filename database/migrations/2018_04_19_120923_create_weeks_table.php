<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWeeksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('weeks', function(Blueprint $table)
		{
			$table->integer('WK_ID')->primary();
			$table->string('WK_Name', 20)->nullable();
			$table->string('Description', 100)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('weeks');
	}

}
