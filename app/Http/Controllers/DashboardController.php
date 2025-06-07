<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function employee()
    {
        return view('employee.dashboard');
    }

    public function admin()
    {
        return view('admin.dashboard');
    }
}
