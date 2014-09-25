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

Route::get('/', function()
{
	return View::make('hello');
});

Route::Controller('users' , 'UsersController');


Route::get('/users/activate/{code}' , array(

      'as'=>'account-activate' , 
      'uses'=>'UsersController@getActivate'
     

	));

Route::get('/users/forget/{code}' , array(

      'as'=>'account-forget' , 
      'uses'=>'UsersController@getForget'
     

	));
