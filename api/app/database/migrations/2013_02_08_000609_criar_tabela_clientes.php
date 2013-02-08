<?php

use Illuminate\Database\Migrations\Migration;

class CriarTabelaClientes extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clientes', function($table)
		{
			$table->increments('id');
			$table->integer('consultor')->unsigned()->foreign()->references('id')->on('contatos');
			$table->integer('contato')->unsigned()->foreign()->references('id')->on('contatos');
			$table->string('numeroDocumento', 15);
			$table->integer('numeroCliente');
			$table->integer('administrador')->unsigned()->foreign()->references('id')->on('contatos');
			$table->string('usuarioAtendimento', 45);
			$table->string('senhaAtendimento', 4);
			$table->string('usuarioGestor', 45);
			$table->string('senhaGestor', 45);
			$table->timestamp('inicioContrato');
			$table->integer('periodo');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clientes');
	}

}