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

Route::get('/', 'MainController@showFeedbacks');

Route::post('/', 'FeedBackFormController@handleSubmission');

Route::post('/updateTable', 'FeedbackTableController@updateTable');

Route::get('/test', function(\Illuminate\Http\Request $request) {

});
