<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified','Blade'])
->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if (in_array($user->role_id,[1,2])) {
            return view('dashboard');

        }else{
            return redirect()->back()->with(['errors_' => [__('msg.access_deny')]]);  
        }
    })->name('dashboard');

    #company
    Route::get('/company','company\CompanyController@index')->name('company');
    Route::post('/company-save','company\CompanyController@save')->name('company.save');
    Route::get('company-datatable', 'company\CompanyController@datatable')->name('company.datatable');

    
    Route::get('/branch', function () {
        return "branch";
    })->name('branch');

    Route::get('/branch-counter', function () {
        return "Branch counter";
    })->name('branch-counter');
    Route::get('/company-profile', function () {
        return "branch";
    })->name('company-profile');
    Route::get('/roles', function () {
        return "branch";
    })->name('roles');
    Route::get('/users', function () {
        return "branch";
    })->name('users');
});
