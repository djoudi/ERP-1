<?php

use Illuminate\Database\Migrations\Migration;

class CriarTabelaEmails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('emails', function($table)
		{
			$table->increments('id');
			$table->string('identificacao');
			$table->string('email', 320);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('emails');
	}

}