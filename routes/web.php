<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Employee\LeaveRequestController as EmployeeLeaveRequestController;
use App\Http\Controllers\Admin\LeaveRequestController as AdminLeaveRequestController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\HomeController;

// Landing page
Route::get('/', function () {
    return view('welcome');
});

// Employee login (Laravel default)
Auth::routes();

// Admin login (custom)
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin-login-page');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login');


// Authenticated dashboards
Route::middleware(['auth'])->group(function () {
    Route::get('/employee/dashboard', [DashboardController::class, 'employee'])->middleware('role:employee')->name('employee.dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->middleware('role:admin')->name('admin.dashboard');
});

// Admin leave management
Route::middleware(['auth', 'role:admin'])->prefix('admin')->as('admin.')->group(function () {
    Route::resource('leave-requests', AdminLeaveRequestController::class);
});

// Employee leave actions
Route::middleware(['auth', 'role:employee'])
    ->prefix('employee')
    ->as('employee.')
    ->group(function () {
        Route::resource('leave-requests', EmployeeLeaveRequestController::class);
});

// Laravel default home
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('admin/leave-requests/{id}/status', [AdminLeaveRequestController::class, 'updateStatus'])
    ->name('admin.leave-requests.status');



