<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::prefix('auth')->middleware('api-header')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
});
Route::group(['middleware' => ['jwt-auth', 'api-header']], function () {
    Route::prefix('notice')->group(function () {
        Route::get('', 'NoticeController@getAll');
        Route::get('/{id}', 'NoticeController@get');

        Route::middleware('admin')->post('/new', 'NoticeController@create');
        Route::middleware('admin')->post('/{id}/update', 'NoticeController@update');
        Route::middleware('admin')->delete('/{id}', 'NoticeController@delete');
    });

    Route::prefix('event')->group(function () {
        Route::get('', 'EventController@getAll');
        Route::get('/expired', 'EventController@getAllExpired');
        Route::get('/{id}', 'EventController@get');

        Route::post('/new', 'EventController@create');
        Route::post('/{id}/update', 'EventController@update');
        Route::post('/{id}/register', 'EventController@registerUser');
        Route::delete('/{id}', 'EventController@delete');
    });

    Route::prefix('billing')->group(function () {
        Route::get('', 'BillingController@getUserBill');
        Route::get('/{id}', 'BillingController@get');
        Route::get('/{id}/pay', 'BillingController@pay');

        Route::middleware('admin')->get('/all', 'BillingController@getAll');
        Route::middleware('admin')->post('/new', 'BillingController@create');
        Route::middleware('admin')->post('/{id}/update', 'BillingController@update');
        Route::middleware('admin')->delete('/{id}', 'BillingController@delete');
    });

    Route::prefix('user')->group(function () {
        Route::get('/me', 'UserController@getCurrentUser');
        Route::post('/me/update', 'UserController@update');

        Route::middleware('admin')->get('/all', 'UserController@getAll');
        Route::middleware('admin')->get('/{id}', 'UserController@get');
        Route::middleware('admin')->get('/{id}/activate', 'UserController@activateUser');
        Route::middleware('admin')->get('/{id}/deactivate', 'UserController@deactivateUser');
        //Route::middleware('admin')->delete('/{id}', 'UserController@delete');
    });
});
