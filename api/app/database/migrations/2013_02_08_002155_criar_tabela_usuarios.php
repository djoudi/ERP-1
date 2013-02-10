<?php

use Illuminate\Database\Migrations\Migration;

class CriarTabelaUsuarios extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usuarios', function($table)
		{
			$table->increments('id');
			$table->integer('contato')->unsigned()->foreign()->references('id')->on('contatos')->unique();
			$table->integer('email')->unsigned()->foreign()->references('id')->on('emails')->unique();
	        $table->string('senha');
	        $table->string('privilegios');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('usuarios');
	}

}