<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Employee\LeaveRequestController as EmployeeLeaveRequestController;
use App\Http\Controllers\Admin\LeaveRequestController as AdminLeaveRequestController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Landing page
Route::view('/', 'welcome');

// Laravel default auth for employees
Auth::routes();

// Custom admin login
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('admin-login-page');
    Route::post('login', [AdminLoginController::class, 'login'])->name('admin.login');
});

// Authenticated dashboard routes
Route::middleware('auth')->group(function () {

    // Employee Dashboard
    Route::middleware('role:employee')->get('/employee/dashboard', [DashboardController::class, 'employee'])->name('employee.dashboard');

    // Admin Dashboard
    Route::middleware('role:admin')->get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

    // Admin Leave Management
    Route::middleware('role:admin')->prefix('admin')->as('admin.')->group(function () {
        Route::get('leave-requests/export/csv', [AdminLeaveRequestController::class, 'exportCsv'])->name('leave-requests.export.csv');
        Route::post('leave-requests/{id}/status', [AdminLeaveRequestController::class, 'updateStatus'])->name('leave-requests.status');
        Route::resource('leave-requests', AdminLeaveRequestController::class);
    });

    // Employee Leave Requests
    Route::middleware('role:employee')->prefix('employee')->as('employee.')->group(function () {
        Route::resource('leave-requests', EmployeeLeaveRequestController::class);
    });
});

// Laravel default home route
Route::get('/home', [HomeController::class, 'index'])->name('home');
