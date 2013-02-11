<?php

use Illuminate\Database\Migrations\Migration;

class CreateTabelaContatosTelefones extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contatos_telefones', function($table)
		{
			$table->increments('id');
			$table->integer('contato_id')->unsigned()->foreign()->references('id')->on('contatos');
			$table->integer('telefone_id')->unsigned()->foreign()->references('id')->on('telefone');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contatos_telefones');
	}

}