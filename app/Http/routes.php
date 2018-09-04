<?php

/*
  |--------------------------------------------------------------------------
  | Routes File
  |--------------------------------------------------------------------------
  |
  | Here is where you will register all of the routes in an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */
//
//Route::get('/user', function () {
//    return view('welcome',['username'=>'ivelin']);
//});



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
//
//Route::group(['middlewareGroups' => ['web']], function () {
//    
//    Route::get('/', 'UserController@index');
//    Route::get('/register', 'UserController@register_form');
//    Route::post('/register', 'UserController@register');
//});

Route::group(['prefix' => 'company'], function () {
    Route::get('/', 'CompanyController@index');

    Route::get('/create', ['as' => 'company_create', 'uses' => 'CompanyController@create']);
    Route::get('/{id}/edit', ['as' => 'company_edit', 'uses' => 'CompanyController@edit']);

    Route::post('/{id}', ['as' => 'company_update', 'uses' => 'CompanyController@update']);
    Route::post('/', ['as' => 'company_store', 'uses' => 'CompanyController@store']);

    Route::get('/show/{id}', ['as' => 'company_show', 'uses' => 'CompanyController@show']);
    Route::get('/delete/{id}', ['as' => 'company_delete', 'uses' => 'CompanyController@delete']);
});

Route::group(['prefix' => 'people'], function() {
    Route::get('/', 'PersonController@index');

    Route::get('/create', ['as' => 'person_create', 'uses' => 'PersonController@create']);
    Route::get('/{id}/edit', ['as' => 'person_edit', 'uses' => 'PersonController@edit']);

    Route::post('/{id}', ['as' => 'person_update', 'uses' => 'PersonController@update']);
    Route::post('/', ['as' => 'person_store', 'uses' => 'PersonController@store']);

    Route::get('/show/{id}', ['as' => 'person_show', 'uses' => 'PersonController@show']);
    Route::get('/delete/{id}', ['as' => 'person_delete', 'uses' => 'CompanyController@delete']);
});

Route::group(['prefix' => 'users'], function() {
    Route::get('/', 'UserController@index');

    Route::get('/create', ['as' => 'user_create', 'uses' => 'UserController@create']);
    Route::get('/{id}/edit', ['as' => 'user_edit', 'uses' => 'UserController@edit']);

    Route::post('/{id}', ['as' => 'user_update', 'uses' => 'UserController@update']);
    Route::post('/', ['as' => 'user_store', 'uses' => 'UserController@store']);
    Route::post('/{id}/file', ['as' => 'user_file', 'uses' => 'UserController@file']);

    
    Route::get('/{id}/activate', ['as' => 'user_activate', 'uses' => 'UserController@activate']);
    Route::get('/{id}/deactivate', ['as' => 'user_deactivate', 'uses' => 'UserController@deactivate']);
    
    Route::get('/{id}/upload', ['as' => 'user_upload', 'uses' => 'UserController@upload']);
});
