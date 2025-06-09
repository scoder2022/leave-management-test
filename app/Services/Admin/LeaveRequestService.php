<?php

namespace App\Services\Admin;

use App\Mail\LeaveStatusChanged;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class LeaveRequestService
{
    public function listLeaveRequests(Request $request)
    {
        return LeaveRequest::with('user')->latest()
            ->when($request->has('status') && $request->status !== 'all', function ($query) use ($request) {
                if (in_array($request->status, ['pending', 'approved', 'rejected'])) {
                    $query->where('status', $request->status);
                }
            })
            ->paginate(10);
    }


    public function updateLeaveRequest(LeaveRequest $leaveRequest, array $data)
    {
        return $leaveRequest->update($data);
    }


    public function deleteLeaveRequest(LeaveRequest $leaveRequest)
    {
        return $leaveRequest->delete();
    }


    public function updateStatus(LeaveRequest $leaveRequest, array $data)
    {
        $leaveRequest->update($data);

        Mail::to($leaveRequest->user->email)->send(new LeaveStatusChanged($leaveRequest));

        return true;
    }


    public function exportToCsv()
    {
        $fileName = 'leave_requests_' . now()->format('Ymd_His') . '.csv';
        $leaveRequests = LeaveRequest::with('user')->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        $columns = ['ID', 'Employee Names', 'Leave Type', 'Start Date', 'End Date', 'Status', 'Leave Reason', 'Admin Comment'];

        $callback = function () use ($leaveRequests, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($leaveRequests as $leave) {
                fputcsv($file, [
                    $leave->id,
                    $leave->user->name ?? 'N/A',
                    $leave->leave_type,
                    $leave->start_date,
                    $leave->end_date,
                    $leave->status,
                    $leave->reason,
                    $leave->admin_comment,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
