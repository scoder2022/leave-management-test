<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Employee\LeaveRequestController as EmployeeLeaveRequestController;
use App\Http\Controllers\Admin\LeaveRequestController as AdminLeaveRequestController;
use App\Mail\LeaveStatusChanged;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Mail;

// Landing page
Route::view('/', 'welcome');

Route::get('/testff',function(){
    $leaveRequest = LeaveRequest::latest()->first();
    $mail = Mail::to("user@user.com")->send(new LeaveStatusChanged($leaveRequest));
    dd($mail);
});

// Laravel default employee auth
Auth::routes();

// Custom admin login
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('login-page');
    Route::post('login', [AdminLoginController::class, 'login'])->name('login');
});

// Authenticated dashboard routes
Route::middleware('auth')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::middleware('role:employee')->prefix('employee')->name('employee.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'employee'])->name('dashboard');
        Route::resource('leave-requests', EmployeeLeaveRequestController::class);
    });

    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'admin'])->name('dashboard');
        Route::resource('leave-requests', AdminLeaveRequestController::class);
        Route::post('leave-requests/{id}/status', [AdminLeaveRequestController::class, 'updateStatus'])->name('leave-requests.status');
    });
});
