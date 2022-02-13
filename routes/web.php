<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForcePasswordChangeController;
use App\Http\Controllers\User\VoteController;
use App\Http\Controllers\Admin\VoteStatusController;
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

// Route::get('/','VoteController@showResult');


// """""""""投票期間が終わったらコメントアウトする
Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// """""""""投票期間が終わったらコメントを外す
// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', 'VoteController@showResult');

Route::get('/force-password-change', [ForcePasswordChangeController::class, 'index'])->name('force-password-change');

Route::group(['middleware'=>'auth'], function() {
    Route::group(['middleware'=>'role:admin', 'prefix'=>'admin', 'as'=>'admin.'], function(){
        // Route::resource('viewのディレクトリ名', コントローラ名::class);
        Route::resource('PasswordResetRequests', Admin\PasswordResetRequestsController::class);
        Route::resource('VoteStatus', Admin\VoteStatusController::class);
    });
    Route::group(['middleware'=>'role:user', 'prefix'=>'user', 'as'=>'user.'], function(){
        // Route::resource('vote', User\VoteController::class);
        Route::get('/vote', [VoteController::class, 'createVote'])->name('vote');
        Route::post('/vote-check', [VoteController::class, 'check'])->name('vote-check');
        Route::post('/vote-result', [VoteController::class, 'vote'])->name('vote-result');
    });
    Route::resource('VoteResult', VoteController::class);


});

Route::get('/home', function () {
    return view('home');
});

Route::get('/view', 'VoteController@view');

Route::get('/statement', function () {
    return view('statement');
});

Route::get('/vote', 'VoteController@createVote');

Route::post('/vote-check', 'VoteController@check');

Route::post('/vote-result','VoteController@vote');

Route::get('/selection-result', 'VoteController@showResult');

Route::get('/vote-monitor', 'VoteController@monitorVote');
