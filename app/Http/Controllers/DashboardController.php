<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function employee()
    {
        return view('employee.dashboard');
    }

    public function admin()
    {
        $leaveCountsByMonth = LeaveRequest::selectRaw('MONTH(start_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month');

        $leaveCountsByType = LeaveRequest::select('leave_type', DB::raw('count(*) as total'))
            ->groupBy('leave_type')
            ->pluck('total', 'leave_type');

        $totalLeaves = LeaveRequest::count();

        return view('admin.dashboard', compact(
            'leaveCountsByMonth',
            'leaveCountsByType',
            'totalLeaves'
        ));
    }
}
