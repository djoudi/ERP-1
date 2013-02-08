<?php

use Illuminate\Database\Migrations\Migration;

class CriarTabelaHistoricos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('historicos', function($table)
		{
			$table->increments('id');
			$table->integer('posVenda')->unsigned()->foreign()->references('id')->on('contatos');
			$table->integer('cliente')->unsigned()->foreign()->references('id')->on('clientes');;
			$table->timestamp('registrado_em');
			$table->text('descricao')->fulltext();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('historicos');
	}

}