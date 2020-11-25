<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::group(['namespace' => 'App\Http\Controllers\Api\V1', 'prefix' => 'v1', 'as' => 'v1.'], function () {

    Route::get('infos', 'MainController@infos');

    Route::group(['middleware' => 'auth.jwt'], function () {

        Route::get('logout', 'JwtAuthController@logout');
        Route::get('user-info', 'JwtAuthController@getUser');
    });

    Route::post('/chat-bot', 'ChatBotController@listenToReplies');
    Route::post('/addqa', 'MainController@addqa');
    Route::get('/getQA', 'MainController@getQA');
    Route::post('/addfb', 'MainController@addfb');
    Route::get('/getfeedback', 'MainController@getFeedback');
    Route::get('/addnachricht', 'MainController@addNachricht');
    Route::get('/getNachricht', 'MainController@getNachrichten');
});
