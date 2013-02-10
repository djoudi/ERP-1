<?php

use Illuminate\Database\Migrations\Migration;

class CriarTabelaTelefones extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('telefones', function($table)
		{
			$table->increments('id');
			$table->string('identificacao');
			$table->string('numero', 40);
			$table->string('operadora')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('telefones');
	}

}