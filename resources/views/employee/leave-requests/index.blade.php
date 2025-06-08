@extends('employee.layouts.app')

@section('content')
<div class="container">
    <h2>My Leave Requests</h2>
    <a href="{{ route('employee.leave-requests.create') }}" class="btn btn-primary mb-3" style="float: right">New Leave Request</a>
    <form method="GET" class="mb-3">
        <select name="status" onchange="this.form.submit()" class="form-control w-auto">
            <option disabled selected>Select Filter By -</option>
            <option value="all" @selected(request()->get('status') === 'all')>Filter By All</option>
            <option value="pending" @selected(request()->get('status') === 'pending')>Pending</option>
            <option value="approved" @selected(request()->get('status') === 'approved')>Approved</option>
            <option value="rejected" @selected(request()->get('status') === 'rejected')>Rejected</option>
        </select>
    </form>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
               <th>S.N</th><th>Type</th><th>Reason</th><th>Dates</th><th>Status</th><th>Admin Comment</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @forelse($leaveRequests as $leave_request)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $leave_request->leave_type }}</td>
                <td>{{ $leave_request->reason }}</td>
                <td>{{ $leave_request->start_date }} to {{ $leave_request->end_date }}</td>
                <td>
                        <span class="font-weight-bold
                            @if($leave_request->status === 'approved') text-success
                            @elseif($leave_request->status === 'rejected') text-danger
                            @else text-primary
                            @endif">
                            {{ ucfirst($leave_request->status) }}
                        </span>

                    </span>
                </td>
                <td>{{ $leave_request->admin_comment ?? '-' }}</td>
                <td>

                @if ($leave_request->status === 'pending')
                <a class="btn btn-xs btn-info" title="Edit Leave Request"
                    href="{{ route('employee.leave-requests.edit',$leave_request->id) }}">
                    <i class="fa fa-edit"></i>
                </a>
                <form action="{{ route('employee.leave-requests.destroy', $leave_request->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-xs btn-danger" title="Remove Leave Request"
                     onclick="return confirm('Are you sure to delete this request?')" title="Delete">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
                @endif

            </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" style="text-align: center;color:red;font-weight:bold">No Data Found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{ $leaveRequests->links() }}
</div>
@endsection
