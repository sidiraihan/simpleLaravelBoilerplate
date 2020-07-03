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
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('member', 'MemberController')->middleware('auth');
Route::resource('transaction', 'TransactionController')->middleware('auth');
Route::get('/report/member', 'TransactionController@report')->middleware('auth');
Route::post('/generate-report/member','TransactionController@generateReport')->middleware('auth');

// Route::get('/contact/listajax','ContactController@listajax')->middleware('auth');
// Route::resource('contacts', 'ContactController')->middleware('auth');

