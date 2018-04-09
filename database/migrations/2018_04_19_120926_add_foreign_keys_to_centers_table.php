<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCentersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('centers', function(Blueprint $table)
		{
			$table->foreign('Center_ID', 'fk_Center_CenterProtocol')->references('Center_ID')->on('center_protocol')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('centers', function(Blueprint $table)
		{
			$table->dropForeign('fk_Center_CenterProtocol');
		});
	}

}
