<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
