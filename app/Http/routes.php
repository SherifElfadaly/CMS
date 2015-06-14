<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/{page?}', 'PagesController@showPage');

Route::get('/admin', ['middleware' => 'AclAuthenticate', function(){
    return view('home');
}]);

Route::get('/admin/changeLanguage/{key}', function($key){
	if($key)
	{
		\Session::put('language', $key);
		\Lang::setlocale($key);
	}
	return redirect()->back();
});