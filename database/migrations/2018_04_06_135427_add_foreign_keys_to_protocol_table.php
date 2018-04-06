<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToProtocolTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('protocol', function(Blueprint $table)
		{
			$table->foreign('Protocol_ID', 'fk_Protocol_CenterProtocol')->references('Protocol_ID')->on('center_protocol')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('protocol', function(Blueprint $table)
		{
			$table->dropForeign('fk_Protocol_CenterProtocol');
		});
	}

}
