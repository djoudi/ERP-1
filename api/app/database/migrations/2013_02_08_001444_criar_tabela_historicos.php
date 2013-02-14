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
			$table->integer('autor')->unsigned()->foreign()->references('id')->on('contatos');
			$table->integer('cliente')->unsigned()->foreign()->references('id')->on('contratos');
			$table->text('descricao')->fulltext();
			$table->timestamps();
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