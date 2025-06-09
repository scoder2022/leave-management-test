@extends('admin.layouts.layout')

@push('css')
<style>

</style>
@endpush

@section('content')
<div class="container">
    <h2>All Leave Requests</h2>
    <a href="{{ route('admin.leave-requests.export.csv') }}" class="btn btn-outline-primary mb-3"
         style="float: right">Export Leave Requests (CSV)</a>

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
                <th>S.N</th>
                <th>Employee</th>
                <th>Type</th>
                <th>Leave Dates</th>
                <th>Requested Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaveRequests as $leave_request)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $leave_request->user->name }}</td>
                <td>{{ $leave_request->leave_type }}</td>
                <td><span class="text-success font-weight-bold">{{ $leave_request->start_date }}</span> to
                    <span class="text-success font-weight-bold"> {{ $leave_request->end_date }}</span> </td>
                <td><span class="text-success font-weight-bold">{{ $leave_request->created_at }}</span></td>
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
                <td>
                    <div class="action">
                        <div class="d-flex flex-column gap-2">
                            <form method="POST" action="{{ route('admin.leave-requests.status', $leave_request->id) }}"
                                class="d-flex gap-2 align-items-center">
                                @csrf
                                <select name="status" class="form-select form-select-sm w-auto">
                                    <option selected disabled>Select Leave Status</option>
                                    <option value="approved" @selected($leave_request->status == 'approved')>Approve</option>
                                    <option value="rejected" @selected($leave_request->status == 'rejected')>Reject</option>

                                </select>
                                <input type="text" name="admin_comment" placeholder="Comment"
                                    class="form-control form-control-sm w-50" value="{{ $leave_request->admin_comment }}">
                                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                            </form>
                        </div>

                        <a href="{{ route('admin.leave-requests.show', $leave_request->id) }}" title="Show/Edit"
                            class="btn btn-sm btn-info mt-4">
                            <i class="fa fa-eye"></i> Show
                        </a>
                        <form action="{{ route('admin.leave-requests.destroy', $leave_request->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure to delete this request?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger mt-4">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;color:red;font-weight:bold">No Data Found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
