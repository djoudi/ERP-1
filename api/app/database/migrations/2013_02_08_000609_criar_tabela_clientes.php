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
			$table->integer('empresa')->unsigned()->foreign()->references('id')->on('contatos');
			$table->integer('consultor')->unsigned()->foreign()->references('id')->on('contatos');
			$table->integer('administrador')->unsigned()->foreign()->references('id')->on('contatos');
			$table->integer('numeroCliente');
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