<?php

namespace App\Services\Employee;

use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;

class LeaveRequestService
{
    public function getUserLeaveRequests($userId, ?string $status = null)
    {
        return LeaveRequest::when(
            $status && $status !== 'all',
            function ($query) use ($status) {
                if (in_array($status, ['pending', 'approved', 'rejected'])) {
                    $query->where('status', $status);
                }
            }
        )
        ->where('user_id', $userId)
        ->latest()
        ->paginate(10);
    }


    public function store(array $data)
    {
        $data['leave_type'] = $data['leave_type'] === 'other' ? $data['custom_leave_type'] : $data['leave_type'];
        unset($data['custom_leave_type']);
        $data['user_id'] = Auth::id();

        LeaveRequest::create($data);
    }


    public function update(LeaveRequest $leaveRequest, array $data)
    {
        $data['leave_type'] = $data['leave_type'] === 'other' ? $data['custom_leave_type'] : $data['leave_type'];
        unset($data['custom_leave_type']);

        $leaveRequest->update($data);
    }


    public function destroy(LeaveRequest $leaveRequest)
    {
        $leaveRequest->delete();
    }

    
    public function updateStatus($id, array $data)
    {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update($data);
    }
}
