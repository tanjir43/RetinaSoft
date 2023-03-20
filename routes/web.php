<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',function() {
    if(Auth::user()) {
        return redirect(url('dashboard'));
    }
    return redirect(url('login'));
});
Route::get('change-lang/{lang}', 'ChangeLangController@index')->name('chang.lang');

Route::post('/login','AuthenticatedSessionController@store');
Route::post('/logout','AuthenticatedSessionController@destroy')->name('logout');;
Route::post('/email/verify/{id}/{hash}','VerifyEmailController@__invoke');


