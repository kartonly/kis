<?php

use Illuminate\Support\Facades\Route;

Route::match(['options', 'post'],'login', 'LoginController')->middleware('cors');;
Route::match(['options', 'post'],'register', 'RegisterController')->middleware('cors');
Route::match(['options', 'post'],'logout', 'LogoutController')->middleware('cors');

Route::match(['options', 'get'],'organisations', 'RegisterController@getOrganisation')->middleware('cors');

