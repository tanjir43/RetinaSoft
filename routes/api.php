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

    Route::get('/app/dashboard', 'admin\DashboardController@index')->name('dashboard');


  /*   $role = Auth::user()->role;
    session()->put('role',strtolower($role));
    if($role->id != 3){
        return redirect()->back()->with(['errors_' => [__('msg.access_deny')]]);  
    }else{
        return redirect(route('dashboard'));
    } */

    #company
    Route::get('company','company\CompanyController@index')->name('company');
    Route::post('company-save/{id?}','company\CompanyController@save')->name('company.save');
    Route::get('company-datatable', 'company\CompanyController@datatable')->name('company.datatable');
    Route::get('company/edit/{id}', 'company\CompanyController@edit')->name('company.edit');
    Route::get('company/block/{id}', 'company\CompanyController@block')->name('company.block');
    Route::get('company/unblock/{id}', 'company\CompanyController@unblock')->name('company.unblock');
    
    #new requested employee
    Route::get('requested-employee','admin\requestedEmployee\RequestedEmployeeController@index')->name('requested.employee');
    Route::get('requested-employee-datatable','admin\requestedEmployee\RequestedEmployeeController@datatable')->name('requested.employee.datatable');
    Route::get('requested-employee-accept/{id}', 'admin\requestedEmployee\RequestedEmployeeController@accept')->name('requested.employee.accept');
    Route::get('requested-employee-reject/{id}', 'admin\requestedEmployee\RequestedEmployeeController@reject')->name('requested.employee.reject');

    #Department
    Route::get('departments', 'employee\DepartmentController@index')->name('departments');
    Route::get('departments-datatable', 'employee\DepartmentController@datatable')->name('department.datatable');
    Route::post('save-department/{id?}', 'employee\DepartmentController@save')->name('department.save');
    Route::get('department-edit/{id}', 'employee\DepartmentController@edit')->name('department.edit');
    Route::get('block-department/{id}', 'employee\DepartmentController@block')->name('department.block');
    Route::get('unblock-department/{id}', 'employee\DepartmentController@unblock')->name('department.unblock');
    
    #Designation
    Route::get('designations', 'employee\DesignationController@index')->name('designations');
    Route::post('save-designation', 'employee\DesignationController@store');
    Route::post('block-designation', 'employee\DesignationController@block');
    Route::post('unblock-designation', 'employee\DesignationController@unblock');
    #Employees
    Route::get('employees', 'employee\EmployeeController@index')->name('employee-list');
    Route::post('save-employee', 'employee\EmployeeController@store');
    Route::post('save-employee-history', 'employee\EmployeeController@store_history');
    Route::post('save-employee-rejoin', 'employee\EmployeeController@store_rejoin');
    Route::get('employee-profile/{id}', 'employee\EmployeeController@profile');

    #attendance 
    Route::get('get-attendance-sheet', 'employee\AttendanceController@index')->name('attendance-sheet');
    Route::get('new-attendance-sheet', 'employee\AttendanceController@create');
    Route::post('save-attendance-sheet', 'employee\AttendanceController@store');
    Route::post('delete-attendance', 'employee\AttendanceController@delete');


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
