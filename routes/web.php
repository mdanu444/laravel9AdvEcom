<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Auth;
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
    Route::middleware(['auth:admin', 'PreventBackHistory'])->group(function(){

        Route::get('/logout', function(){
            Auth::guard('admin')->logout();
            return redirect()->route('admin.login');

        })->name('logout');

        Route::get('/home', function () {
            Session::put('pageTitle', 'Home');
            return view('admin.home');
        })->name('home');

        Route::get('/profile/password', function () {
            Session::put('pageTitle', 'Profile');
            return view('admin.profile-changePassword');
        })->name('profile.changePassword');

        Route::put('/profile/password', [AdminController::class, 'changepse'])->name('profile.updatepsw');

        Route::get('/profile/update', function () {
            Session::put('pageTitle', 'Profile');
            return view('admin.profile-update');
        })->name('profile.update');
    });
    Route::middleware(['guest:admin', 'PreventBackHistory'])->group(function(){
        Route::view('/login', 'admin.login')->name('login');
        Route::post('/login', [AdminController::class, 'check'])->name('check');
        Route::view('/register', 'admin.register')->name('register');
        Route::post('/register', [AdminController::class, 'save'])->name('save');
    });
});
