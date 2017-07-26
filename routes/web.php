<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'FrontendController@index');
Route::get('vizControl', 'VizController@show');
Route::get('bubbleViz/{question}', 'VizController@visualize');
Route::get('bubbleViz/{question}/ajaxHandler', 'VizController@ajaxHandler');

Route::get('questionnaire/{category}/questions', 'FrontendController@showQuestion');
Route::get('questionnaire/{category}/ajaxHandler', 'FrontendController@ajaxHandler');
Route::post('questionnaire/{question}/vote', 'FrontendController@vote');

Route::get('/backend', 'BackendController@index')->name('home');

Route::get('categories/create','CategoryController@create');
Route::get('categories/{category}', 'CategoryController@show');
Route::get('categories/{category}/edit', 'CategoryController@edit');
Route::patch('categories/{category}', 'CategoryController@update');
Route::post('categories', 'CategoryController@store');
Route::delete('categories/{category}', 'CategoryController@destroy');

Route::get('categories/{category}/questions/create','QuestionController@create');
Route::post('categories/{category}/questions', 'QuestionController@store');
Route::delete('categories/{category}/questions/{question}', 'QuestionController@destroy');
Route::patch('categories/{category}/questions/{question}/activate', 'QuestionController@activate');
Route::patch('categories/{category}/questions/{question}/deactivate', 'QuestionController@deactivate');
Route::delete('categories/{category}/questions/{question}/clearVotes', 'QuestionController@clearVotes');


// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
