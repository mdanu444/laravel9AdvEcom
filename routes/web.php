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
    return view('fontend.welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/logout', function(){
        return 'logout';
    })->name('logout');

    Route::get('/home', function () {
        return view('admin.home');
    })->name('home');

});
