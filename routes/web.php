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

Route::get('/', 'QuestionsController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('email/verify/{token}', ['as'=>'email.verify', 'uses' => 'EmailController@verify']);

Route::resource('questions', 'QuestionsController');

Route::post('/question/{question}/answer', 'AnswersController@store');

Route::get('/question/{question}/follow', 'QuestionFollowController@follow');

Route::get('/notifications', 'NotificationsController@index');
Route::get('/notifications/{notificationId}', 'NotificationsController@show');

Route::get('/inbox', 'InboxController@index');
Route::get('/inbox/{dialogId}', 'InboxController@show');
Route::post('/inbox/{dialogId}/store', 'InboxController@store');

Route::get('/avatar', 'UsersController@avatar');