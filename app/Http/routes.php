<?php

Route::get('/login', ['as' => 'login', 'uses' => 'HomeController@index']);

Route::post('/auth', 'HomeController@auth');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['prefix' => 'company'], function () {
        Route::get('/', ['as' => 'company_index', 'uses' => 'CompanyController@index']);

        Route::get('/create', ['as' => 'company_create', 'uses' => 'CompanyController@create']);
        Route::get('/{id}/edit', ['as' => 'company_edit', 'uses' => 'CompanyController@edit']);

        Route::post('/{id}', ['as' => 'company_update', 'uses' => 'CompanyController@update']);
        Route::post('/', ['as' => 'company_store', 'uses' => 'CompanyController@store']);

        Route::get('/show/{id}', ['as' => 'company_show', 'uses' => 'CompanyController@show']);
        Route::get('/delete/{id}', ['as' => 'company_delete', 'uses' => 'CompanyController@delete']);




        Route::get('service/post/show', 'CompanyController@show');
        Route::get('service/post/create', 'CompanyController@create');
        Route::get('service/post/update', 'CompanyController@update');
        Route::get('service/post/delete', 'CompanyController@delete');
    });

    Route::group(['prefix' => 'people'], function() {
        Route::get('/', 'PersonController@index');

        Route::get('/create', ['as' => 'person_create', 'uses' => 'PersonController@create']);
        Route::get('/{id}/edit', ['as' => 'person_edit', 'uses' => 'PersonController@edit']);

        Route::post('/{id}', ['as' => 'person_update', 'uses' => 'PersonController@update']);
        Route::post('/', ['as' => 'person_store', 'uses' => 'PersonController@store']);

        Route::get('/show/{id}', ['as' => 'person_show', 'uses' => 'PersonController@show']);
        Route::get('/delete/{id}', ['as' => 'person_delete', 'uses' => 'PersonController@delete']);
    });

    Route::group(['prefix' => 'users'], function() {
        Route::get('/', 'UserController@index');

        Route::get('/create', ['as' => 'user_create', 'uses' => 'UserController@create']);
        Route::get('/roles', ['as' => 'roles_manage', 'uses' => 'RolesController@roles']);
        Route::get('/manage/{id}', ['as' => 'permissions_list', 'uses' => 'RolesController@permission']);
        Route::get('/{id}/edit', ['as' => 'user_edit', 'uses' => 'UserController@edit']);
        Route::get('/{id}', ['as' => 'change_language', 'uses' => 'LanguageController@change']);
        
        Route::post('/{id}', ['as' => 'user_update', 'uses' => 'UserController@update']);
        Route::post('/', ['as' => 'user_store', 'uses' => 'UserController@store']);
        Route::post('/{id}/file', ['as' => 'user_file', 'uses' => 'UserController@file']);
        Route::post('/', ['as' => 'user_manage', 'uses' => 'RolesController@manage']);
        
        Route::get('/{id}/activate', ['as' => 'user_activate', 'uses' => 'UserController@activate']);
        Route::get('/{id}/deactivate', ['as' => 'user_deactivate', 'uses' => 'UserController@deactivate']);

        Route::get('/{id}/upload', ['as' => 'user_upload', 'uses' => 'UserController@upload']);
        
    });

    Route::get('/logout', 'HomeController@logout');
});


Route::get('/', 'HomeController@index');
