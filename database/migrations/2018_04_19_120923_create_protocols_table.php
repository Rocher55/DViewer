<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProtocolsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('protocols', function(Blueprint $table)
		{
			$table->integer('Protocol_ID', true);
			$table->string('Protocol_Name', 30);
			$table->string('Protocol_Type', 30);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('protocols');
	}

}
