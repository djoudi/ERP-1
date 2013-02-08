<?php

use Illuminate\Database\Migrations\Migration;

class CriarTabelaSessoes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sessoes', function($table)
		{
			$table->increments('id');
			$table->string('hash', 32);
			$table->integer('usuario')->unsigned()->foreign()->references('id')->on('usuarios');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sessoes');
	}

}