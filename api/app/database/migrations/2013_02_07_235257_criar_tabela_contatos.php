<?php

use Illuminate\Database\Migrations\Migration;

class CriarTabelaContatos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contatos', function($table)
		{
			$table->increments('id');
			$table->string('nome');
			$table->boolean('pessoaJuridica')->default(false);
			$table->text('descricao')->nullable()->fulltext();
			$table->timestamp('registrado_em');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contatos');
	}

}