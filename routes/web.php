<?php

use Illuminate\Support\Facades\Route;

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
});
Route::resource('note', 'NoteController');
Route::resource('task', 'TaskController');
Route::resource('project', 'ProjectController');
Route::get('projects', 'ProjectController@projects');
Route::get('/comments/{id}', 'ProjectController@comments');
Route::get('/task/complete/{id}', 'TaskController@complete');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
