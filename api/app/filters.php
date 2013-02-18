<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS');
	header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, X-PINGARUNER');
    header('Access-Control-Max-Age: 1728000');
	header('Content-Type: application/json');

	if($_SERVER['REQUEST_METHOD'] == "OPTIONS")
    {
	    header("Content-Length: 0");
    	exit(0);
    }

});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. Also, a "guest" filter is
| responsible for performing the opposite. Both provide redirects.
|
*/

// Route::filter('apiauth', function()
// {
//     // Test against the presence of Basic Auth credentials
//     $creds = [
//         'username' => Request::getUser(),
//         'password' => Request::getPassword(),
//     ];
//     if ( ! Auth::attempt($creds) ) {
//         return (($response = Response::json([
//             'error' => true,
//             'message' => 'Unauthorized Request'],
//             401
//         )) && Input::has('callback')?$response->setCallback(Input::get('callback')):$response);
//     }
// });


Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::getToken() != Input::get('csrf_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});