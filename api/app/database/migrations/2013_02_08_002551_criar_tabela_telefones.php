<?php

use Illuminate\Database\Migrations\Migration;

class CriarTabelaTelefones extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('telefones', function($table)
		{
			$table->increments('id');
			$table->integer('contato')->unsigned()->foreign()->references('id')->on('contatos');
			$table->string('numero', 40);
			$table->string('identificacao');
			$table->string('operadora')->nullable();
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
		Schema::drop('telefones');
	}

}