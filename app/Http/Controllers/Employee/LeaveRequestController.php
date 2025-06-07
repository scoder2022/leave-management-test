<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->status;
        $leaveRequests = LeaveRequest::when($status !== 'all',
            function ($query) use ($status) {
                if (in_array($status, ['pending', 'approved', 'rejected'])) {
                    $query->where('status', $status);
                }
            }
        )
        ->where('user_id', auth()->id())
        ->latest()
        ->paginate(10);
        return view('employee.leave_requests.index', compact('leaveRequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('employee.leave_requests.create');
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'leave_type' => 'required|string|max:255',
            'custom_leave_type' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
        ]);

        $data['leave_type'] = $data['leave_type'] === 'other' ? $data['custom_leave_type'] : $data['leave_type'];
        unset($data['custom_leave_type']);
        $data['user_id'] = auth()->id();
        LeaveRequest::create($data);

        return redirect()->route('employee.leave-requests.index')->with('success', 'Leave request submitted.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaveRequest $leaveRequest)
    {
        $this->authorize('update', $leaveRequest);

        return view('employee.leave_requests.edit',['leaveRequest' => $leaveRequest]);
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, LeaveRequest $leaveRequest)
    {

        $this->authorize('update', $leaveRequest);

         $data = $request->validate([
            'leave_type' => 'required|string|max:255',
            'custom_leave_type' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
        ]);

        $data['leave_type'] = $data['leave_type'] === 'other' ? $data['custom_leave_type'] : $data['leave_type'];
        unset($data['custom_leave_type']);
            $data['user_id'] = auth()->id();
            LeaveRequest::create($data);

        return redirect()->route('employee.leave-requests.index')->with('success', 'Leave request updated.');

    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(LeaveRequest $leaveRequest)
    {
        try {
            $this->authorize('delete', $leaveRequest);

            $leaveRequest->delete();

            return redirect()
                ->route('employee.leave-requests.index')
                ->with('success', 'Leave request deleted successfully.');
        } catch (AuthorizationException $e) {
            return redirect()
                ->route('employee.leave-requests.index')
                ->with('error', $e->getMessage()); // shows custom policy message
        }
    }

}
