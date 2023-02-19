<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'user'], function () {
    Route::get('/','\App\Http\Controllers\API\User\UsersController@index');
    Route::put('update','\App\Http\Controllers\API\User\UsersController@update');
    Route::post('{user}/avatar', '\App\Http\Controllers\API\User\UsersController@setAvatar');
    Route::match(['options', 'post'],'{user}/photo', '\App\Http\Controllers\API\User\UsersController@setPhoto');
    Route::match(['options', 'post'],'{user}/photo/delete', '\App\Http\Controllers\API\User\UsersController@deletePhoto');
});

Route::group(['prefix' => 'clients'], function () {
    Route::get('/','\App\Http\Controllers\API\User\ClientController@index');
    Route::get('{client}','\App\Http\Controllers\API\User\ClientController@item');
    Route::match(['options', 'put'],'{client}/update','\App\Http\Controllers\API\User\ClientController@update')->middleware('cors');
    Route::match(['options', 'post'],'create','\App\Http\Controllers\API\User\ClientController@create')->middleware('cors');
    Route::match(['options', 'post'],'create/passport/{client}','\App\Http\Controllers\API\User\ClientController@createPassport')->middleware('cors');
    Route::match(['options', 'post'],'delete/passport/{passport}','\App\Http\Controllers\API\User\ClientController@deletePassport')->middleware('cors');
    Route::match(['options', 'put'],'update/passport/{passport}','\App\Http\Controllers\API\User\ClientController@updatePassport')->middleware('cors');
    Route::match(['options', 'post'],'create/intPassport/{client}','\App\Http\Controllers\API\User\ClientController@createIntPassport')->middleware('cors');
    Route::match(['options', 'delete', 'post'],'{client}/delete','\App\Http\Controllers\API\User\ClientController@delete')->middleware('cors');
});

Route::group(['prefix' => 'users'], function () {
    Route::get('/','\App\Http\Controllers\API\Admin\UsersController@index');
    Route::get('{user}','\App\Http\Controllers\API\Admin\UsersController@item');
    Route::match(['options', 'put'],'{user}/update','\App\Http\Controllers\API\Admin\UsersController@update')->middleware('cors');
    Route::delete('{user}/delete', '\App\Http\Controllers\API\Admin\UsersController@delete');
});

Route::group(['prefix' => 'preagreements'], function (){
    Route::get('/', "\App\Http\Controllers\API\User\PreagreementController@index");
    Route::get('reminder', "\App\Http\Controllers\API\User\PreagreementController@reminder");
    Route::get('{preagr}', "\App\Http\Controllers\API\User\PreagreementController@item");
    Route::match(['options', 'put'],'{preagreement}/update', "\App\Http\Controllers\API\User\PreagreementController@update")->middleware('cors');
    Route::match(['options', 'put'],'{preagreement}/updateCities', "\App\Http\Controllers\API\User\PreagreementController@updateCities")->middleware('cors');
    Route::match(['options', 'post'],'create', "\App\Http\Controllers\API\User\PreagreementController@create")->middleware('cors');
    Route::match(['options', 'post', 'delete','put', 'get'],'{preagreement}/delete', "\App\Http\Controllers\API\User\PreagreementController@delete")->middleware('cors');
});

Route::group(['prefix' => 'cities'], function (){
    Route::get('/', "\App\Http\Controllers\API\User\PreagreementController@getCities");
});
Route::group(['prefix' => 'countries'], function (){
    Route::get('/', "\App\Http\Controllers\API\User\PreagreementController@getCountries");
});

Route::group(['prefix' => 'hotels'], function (){
    Route::get('/', "\App\Http\Controllers\API\User\PreagreementController@getHotels");
});

Route::group(['prefix' => 'agreements'], function (){
    Route::get('/', "\App\Http\Controllers\API\User\AgreementController@index");
    Route::get('{agr}', "\App\Http\Controllers\API\User\AgreementController@item");
    Route::match(['options', 'put'],'{agr}/addTourist', "\App\Http\Controllers\API\User\AgreementController@addTourist")->middleware('cors');
    Route::get('preagreement/{agr}', "\App\Http\Controllers\API\User\AgreementController@preagr");
    Route::match(['options', 'post'],'{preagr}/create', "\App\Http\Controllers\API\User\AgreementController@create")->middleware('cors');
    Route::match(['options', 'post', 'delete','put', 'get'],'{agreement}/delete', "\App\Http\Controllers\API\User\AagreementController@delete")->middleware('cors');
});

Route::group(['prefix' => 'payments'], function (){
    Route::get('/', "\App\Http\Controllers\API\User\PaymentController@index");
    Route::get('values', "\App\Http\Controllers\API\User\PaymentController@values");
    Route::get('{agr}', "\App\Http\Controllers\API\User\PaymentController@item")->middleware('cors');
    Route::match(['options', 'post'],'{agr}/create', "\App\Http\Controllers\API\User\PaymentController@create")->middleware('cors');
});

Route::group(['prefix' => 'vauchers'], function (){
    Route::get('/', "\App\Http\Controllers\API\User\VaucherController@index");
    Route::get('{voucher}', "\App\Http\Controllers\API\User\VaucherController@item");
    Route::match(['options', 'post'],'{agr}/create', "\App\Http\Controllers\API\User\VaucherController@create")->middleware('cors');
});

