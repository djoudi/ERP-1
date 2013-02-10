<?php

use Illuminate\Database\Migrations\Migration;

class CreateTabelaContatosEmails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contatos_emails', function($table)
		{
			$table->increments('id');
			$table->integer('contato_id')->unsigned()->foreign()->references('id')->on('contatos');
			$table->integer('email_id')->unsigned()->foreign()->references('id')->on('emails');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contatos_emails');
	}

}