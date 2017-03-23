<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

// Auth routes
Auth::routes();
Route::get('auth/slack', 'Auth\LoginController@redirectToProvider');
Route::get('auth/slack/callback', 'Auth\LoginController@handleProviderCallback');

// Main home route
Route::get('/', 'HomeController@index');
Route::post('/{chat}', 'HomeController@send');

// Get chats

// Channels routes
Route::get('/channels/get', 'ChannelController@get');
Route::get('/channels/chat/{chat}', 'ChannelController@chat');
Route::get('/channels/chat/{chat}/{page?}', 'ChannelController@pagination');

// Messages routes
Route::get('/ims/chat/{chat}/', 'ImController@chat');
Route::get('/ims/new/{slackId}', 'ImController@newChat');
Route::get('/ims/chat/{chat}/{page?}', 'ImController@pagination');
Route::post('/ims/send', 'ImController@send');
Route::get('/ims/get', 'ImController@get');

// Groups routes
Route::get('/groups', 'GroupController@index');
Route::get('/groups/get', 'GroupController@get');
Route::get('/groups/chat/{chat}', 'GroupController@chat');
Route::get('/groups/chat/{chat}/{page?}', 'GroupController@pagination');

Route::get('/test', 'TestController@index');

//All channels and users
Route::get('/channels','HomeController@allChannels');
Route::get('/ims','HomeController@allUsers');
Route::get('/groups','HomeController@allGroups');

