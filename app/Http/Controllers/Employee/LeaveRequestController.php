<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreLeaveRequest;
use App\Http\Requests\Employee\UpdateLeaveRequest;
use App\Models\LeaveRequest;
use App\Services\Employee\LeaveRequestService;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\AuthorizationException;

class LeaveRequestController extends Controller
{
    protected $leaveRequestService;
    protected $base_route = 'employee.leave-requests';
    protected $panel_name = 'Leave Request';

    public function __construct(LeaveRequestService $leaveRequestService)
    {
        $this->leaveRequestService = $leaveRequestService;
    }


    public function index(Request $request)
    {
        $leaveRequests = $this->leaveRequestService->getUserLeaveRequests(auth()->id(), $request->status);
        return view($this->base_route.'.index', compact('leaveRequests'));
    }


    public function create()
    {
        return view($this->base_route.'.create');
    }


    public function store(StoreLeaveRequest $request)
    {
        $this->leaveRequestService->store($request->validated());
        return redirect()->route($this->base_route.'.index')->with('success', $this->panel_name.' Submitted.');
    }


    public function show(string $id)
    {

    }


    public function edit(LeaveRequest $leaveRequest)
    {
        $this->authorize('update', $leaveRequest);
        return view($this->base_route.'.edit', ['leaveRequest' => $leaveRequest]);
    }


    public function update(UpdateLeaveRequest $request, LeaveRequest $leaveRequest)
    {
        $this->authorize('update', $leaveRequest);
        $this->leaveRequestService->update($leaveRequest, $request->validated());
        return redirect()->route($this->base_route.'.index')->with('success', $this->panel_name.' Updated.');
    }


    public function destroy(LeaveRequest $leaveRequest)
    {
        try {
            $this->authorize('delete', $leaveRequest);
            $this->leaveRequestService->destroy($leaveRequest);
            return redirect()->route($this->base_route.'.index')->with('success', $this->panel_name.' Deleted.');
        } catch (AuthorizationException $e) {
            return redirect()->route($this->base_route.'.index')->with('error', $e->getMessage());
        }
    }


    public function updateStatus(Request $request, $id)
    {
        $this->leaveRequestService->updateStatus($id, $request->validated());
        return back()->with('success', $this->panel_name.' status Update.');
    }

}
