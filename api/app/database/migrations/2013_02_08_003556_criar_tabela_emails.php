
<?php

use Illuminate\Database\Migrations\Migration;

class CriarTabelaEmails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('emails', function($table)
		{
			$table->increments('id');
			$table->string('identificacao');
			$table->integer('contato')->unsigned()->foreign()->references('id')->on('contatos');
			$table->string('email', 320);
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
		Schema::drop('emails');
	}

}