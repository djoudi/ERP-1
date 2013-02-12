<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


// Acesso direto Contatos
Route::resource('contatos', 'ContatosController');

// Acesso através dos Contatos
Route::group(array('prefix' => 'contatos/{id}'), function()
{
	Route::resource('emails'    , 'EmailsController');   
	Route::resource('telefones' , 'TelefonesController');
});


Route::get('/', function()
{
});
