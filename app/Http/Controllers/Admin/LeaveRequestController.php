<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\LeaveStatusChanged;
use App\Models\LeaveRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LeaveRequest::with('user')->latest();

        // Optional filter by status
        if ($request->has('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        $leaveRequests = $query->paginate(10);

        return view('admin.leave_requests.index', compact('leaveRequests'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

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

        return redirect()->route('admin.leave-requests.index')->with('success', 'Leave request submitted.');
    }
    /**
     * Display the specified resource.
     */
    public function show(LeaveRequest $leaveRequest)
    {
        return view('admin.leave_requests.show',compact('leaveRequest'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaveRequest $leaveRequest)
    {
        return view('admin.leave_requests.edit',compact('leaveRequest'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, LeaveRequest $leaveRequest)
    {

        $this->authorize('update', $leaveRequest);

        $validated = $request->validate([
            'leave_type' => 'required|string',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
        ]);

        $leaveRequest->update($validated);

        return redirect()->route('admin.leave-requests.index')->with('success', 'Leave request updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaveRequest $leaveRequest)
    {
        try {
            $leaveRequest->delete();
            return redirect()
                ->route('admin.leave-requests.index')
                ->with('success', 'Leave request deleted successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.leave-requests.index')
                ->with('error', $e->getMessage()); // shows custom policy message
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_comment' => 'nullable|string',
        ]);

        $leaveRequest = LeaveRequest::with('user')->findOrFail($id);
        $leaveRequest->update($validated);

        return redirect()->route('admin.leave-requests.index')->with('success', 'Leave status updated.');
    }

}
