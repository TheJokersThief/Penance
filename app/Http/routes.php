<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
Route::group(['middleware' => ['web']], function () {
	Route::auth();

	Route::get('/', function () {
	    return view('welcome');
	});

	Route::group(['middleware' => ['auth']], function( ){
		Route::resource('list', 'ListController', [ 'only' => ['store', 'show', 'edit', 'index', 'create'] ]);
	});
});

Route::group(['middleware' => ['api', 'auth']], function( ){
	Route::resource('task', 'TaskController', [ 'only' => ['store', 'update', 'destroy'] ] );
	Route::resource('list', 'ListController', [ 'only' => ['update', 'destroy'] ]);
});
