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
    $user = Auth::user();
    if($user) {
        if (in_array($user->role_id,[1,2])) {
            return redirect(url('dashboard'));
        }else{
            return redirect('my.profile');
        }
    }
    return redirect(url('login'));
});

/* Route::get('/', function () {
    $user = Auth::user();
        if (in_array($user->role_id,[1,2])) {
            return redirect()->back()->with(['errors_' => [__('msg.access_deny')]]);  
        }else{
            return redirect(route('dashboard'));
        }
}); */
Route::get('change-lang/{lang}', 'ChangeLangController@index')->name('chang.lang');

Route::post('/login','AuthenticatedSessionController@store');
Route::post('/logout','AuthenticatedSessionController@destroy')->name('logout');;
Route::post('/email/verify/{id}/{hash}','VerifyEmailController@__invoke');

Route::get('/my-profile','website\MyAccountController@index')->name('my.profile');

