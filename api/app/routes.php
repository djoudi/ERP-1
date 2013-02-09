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


Route::post('contatos.(:ext)'  , "ContatosController@store"); 
Route::get('contatos{ext?}/id'  , "ContatosController@index"); 
Route::get('contatos.(:ext)/(:id)'  , "ContatosController@show"); 
Route::put('contatos.(:ext)/(:id)'  , "ContatosController@update"); 
Route::delete('contatos.(:ext)'  , "ContatosController@destroy"); 


// Route::resource('clientes.{ext}'  , "ClientesController"); 
// Route::resource('telefones.{ext}' , "TelefonesController"); 
// Route::resource('emails.{ext}'	, "EmailsController"); 

// # CRUD
// Route::get('contatos/{contato_id}/telefones' 	  , "TelefonesController@index");
// Route::get('contatos/{contato_id}/emails' 		  , "EmailsController@index");

// # READ
// Route::get('contatos/{contato_id}/telefones/' 	  , "TelefonesController@index");
// Route::get('contatos/{contato_id}/emails/' 		  , "EmailsController@index");
// Route::get('contatos/{contato_id}/telefones/{id}' , "TelefonesController@show");
// Route::get('contatos/{contato_id}/emails/{id}' 	  , "EmailsController@show");


Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/authtest', array('before' => 'apiauth', function()
{
    return View::make('hello');
}));