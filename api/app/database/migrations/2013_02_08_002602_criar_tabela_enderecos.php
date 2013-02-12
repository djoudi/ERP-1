<?php

use Illuminate\Database\Migrations\Migration;

class CriarTabelaEnderecos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('enderecos', function($table)
		{
			$table->increments('id');
			$table->integer('contato')->unsigned()->foreign()->references('id')->on('contatos');
			$table->string('identificacao');
			$table->string('numero', 10)->nullable();
			$table->string('logradouro', 200);
			$table->string('bairro',100);
			$table->string('complemento',200);
			$table->string('localidade', 200);
			$table->string('uf', 2);
			$table->string('cep', 8)->nullable();
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
		Schema::drop('enderecos');
	}

}