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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['middleware'=>'auth'], function() {
    Route::group(['middleware'=>'role:admin', 'prefix'=>'admin', 'as'=>'admin.'], function(){
        Route::resource('RequestPasswordReset', RequestPasswordReset\ListController::class);
    });
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/view', 'VoteController@view');

Route::get('/statement', function () {
    return view('statement');
});

Route::get('/vote', function () {
    return view('vote');
});

Route::post('/vote-check', 'VoteController@check');

Route::post('/vote-result','VoteController@vote');
