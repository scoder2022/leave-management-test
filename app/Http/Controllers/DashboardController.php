<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function employee()
    {
        $leaveCountsByMonth = LeaveRequest::where('user_id', auth()->id())
            ->selectRaw('MONTH(start_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->mapWithKeys(function ($count, $month) {
                $monthName = Carbon::create()->month($month)->format('F');
                return [$monthName => $count];
            });

        $leaveCountsByType = LeaveRequest::where('user_id', auth()->id())
            ->select('leave_type', DB::raw('count(*) as total'))
            ->groupBy('leave_type')
            ->pluck('total', 'leave_type');

        $totalLeaves = LeaveRequest::where('user_id', auth()->id())->count();

        return view('employee.dashboard', compact('leaveCountsByMonth', 'leaveCountsByType', 'totalLeaves'));
    }

    public function admin()
    {
        $leaveCountsByMonth = LeaveRequest::selectRaw('MONTH(start_date) as month, COUNT(*) as count')
            ->groupBy('month')
            ->pluck('count', 'month')
            ->mapWithKeys(function ($count, $month) {
                $monthName = Carbon::create()->month($month)->format('F');
                return [$monthName => $count];
            });

        $leaveCountsByType = LeaveRequest::select('leave_type', DB::raw('count(*) as total'))
            ->groupBy('leave_type')
            ->pluck('total', 'leave_type');

        $totalLeaves = LeaveRequest::count();

        return view('admin.dashboard', compact('leaveCountsByMonth','leaveCountsByType','totalLeaves'));
    }
}
