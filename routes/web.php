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

Route::get('/', function () {
    return view('welcome');
})->name('/');

//Route::get('/comments','CommentsController@index');
Route::get('/comments','CommentsController@index')->name('comments');
Route::get('/create','CommentsController@create')->name('create');
Route::post('/create', 'CommentsController@store')->name('store');
Route::get('/delete/{id}', 'CommentsController@destroy')->name('delete');
Route::get('/edit/{id}','CommentsController@edit')->name('edit');
Route::put('{id}','CommentsController@update')->name('update');

Route::get('/editEvent/{id}', 'EventController@edit')->name('editEvent');
Route::put('{id}', 'EventController@update')->name('updateEvent');


Route::get('/createEvent', 'EventController@create')->name('createEvent');
Route::post('/createEvent', 'EventController@store')->name('storeEvent');
Route::get('/deleteEvent/{id}', 'EventController@destroy')->name('deleteEvent');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('event/create', 'EventController@create')->name('event.create');
Route::get('event/{event}', 'EventController@show')->name('event.show');
Route::get('user/event/{event}', 'EventController@removeUser')->name('user.event.delete');
Route::get('/choose','EventController@choose')->name('choose');
//Route::get('user/{id}','EventController@choose')->name('choose');