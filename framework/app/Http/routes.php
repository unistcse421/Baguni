<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/','MainController@index');
Route::get('/main','MainController@Main');
Route::get('/mypage','MainController@Mypage');
Route::get('/upload','MainController@Upload');
Route::post('/ajaxJoin','MainController@AjaxJoin');
Route::post('/ajaxLogin','MainController@AjaxLogin');
Route::post('/ajaxUpload','MainController@AjaxUpload');
Route::get('/ajaxContent','MainController@AjaxContent');
Route::get('/ajaxDetails/{id}','MainController@AjaxGetDetails');
Route::get('/ajaxMyItem','MainController@AjaxMyItem');
Route::Get('/updateItem/{id}','MainController@UpdateItem');