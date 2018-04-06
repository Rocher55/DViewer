<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGeneTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gene', function(Blueprint $table)
		{
			$table->string('Gene_Symbol', 50);
			$table->string('Probe_ID', 30);
			$table->string('Gene_Name', 400)->nullable();
			$table->string('Target_ID', 25)->nullable();
			$table->unique(['Gene_Symbol','Probe_ID'], 'index_gene');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('gene');
	}

}
