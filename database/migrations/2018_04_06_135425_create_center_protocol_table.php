<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCenterProtocolTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('center_protocol', function(Blueprint $table)
		{
			$table->integer('Center_ID');
			$table->integer('Protocol_ID')->index('fk_CenterProtocol_Protocol');
			$table->primary(['Center_ID','Protocol_ID']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('center_protocol');
	}

}
