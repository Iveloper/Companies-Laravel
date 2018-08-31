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
   // Route::get('/sort/{sort}/order/{order}', 'CompanyController@index');
    Route::get('/companydelete/id/{id}', 'CompanyController@companydelete');
    Route::get('/companyadd', function() {
        return view('/companies/companyadd');
    });
    Route::post('/companyaddForm', 'CompanyController@companyadd');
    Route::post('/companyeditForm', 'CompanyController@companyadd');
    Route::get('/companyrecord/id/{id}', 'CompanyController@companyrecord');
    Route::get('/companyedit/id/{id}', 'CompanyController@companyedit');
});

Route::group(['prefix' => 'people'], function(){
    Route::get('/', 'PersonController@index');
    Route::get('/delete/id/{id}', 'PersonController@delete');
    Route::get('/add', 'PersonController@personadd');
    Route::post('/addForm', 'PersonController@add');
    Route::post('/editForm', 'PersonController@add');
    Route::get('/record/id/{id}', 'PersonController@record');
    Route::get('/edit/id/{id}', 'PersonController@edit');
    
});