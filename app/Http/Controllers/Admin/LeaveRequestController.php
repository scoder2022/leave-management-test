<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLeaveRequest;
use App\Models\LeaveRequest;
use App\Services\Admin\LeaveRequestService;
use Exception;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    protected $leaveRequestService;

    protected $base_route = 'admin.leave-requests';
    protected $panel_name = 'Leave Request';

    public function __construct(LeaveRequestService $leaveRequestService)
    {
        $this->leaveRequestService = $leaveRequestService;
    }


    public function index(Request $request)
    {
        $leaveRequests = $this->leaveRequestService->listLeaveRequests($request);
        return view($this->base_route.'.index', compact('leaveRequests'));
    }


    public function create()
    {
    }


    public function store()
    {

    }


    public function show(LeaveRequest $leaveRequest)
    {
        return view($this->base_route.'.show',compact('leaveRequest'));
    }


    public function edit(LeaveRequest $leaveRequest)
    {
        return view($this->base_route.'.edit',compact('leaveRequest'));
    }


   public function update(Request $request,LeaveRequest $leaveRequest)
    {

    }


    public function destroy(LeaveRequest $leaveRequest)
    {
        try {
            $this->leaveRequestService->deleteLeaveRequest($leaveRequest);
            return redirect()->route($this->base_route.'.index')->with('success', $this->panel_name.' Deleted Successfully.');
        } catch (\Exception $e) {
            return redirect()->route($this->base_route.'.index')->with('error', $e->getMessage());
        }
    }


    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'admin_comment' => 'required|string',
        ]);

        $leaveRequest = LeaveRequest::with('user')->findOrFail($id);

        $this->leaveRequestService->updateStatus($leaveRequest, $validated);

        return redirect()->route($this->base_route.'.index')->with('success', $this->panel_name.' Status updated.');
    }


    public function exportCsv()
    {
        return $this->leaveRequestService->exportToCsv();
    }

}
