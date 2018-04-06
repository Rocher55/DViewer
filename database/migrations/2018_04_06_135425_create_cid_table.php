<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCidTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cid', function(Blueprint $table)
		{
			$table->integer('CID_ID', true);
			$table->integer('CID_Number');
			$table->string('CID_Name', 50)->nullable();
			$table->string('Definition', 50)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cid');
	}

}
