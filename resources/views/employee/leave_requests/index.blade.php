@extends('employee.layouts.app')

@section('content')
<div class="container">
    <h2>My Leave Requests</h2>
    <a href="{{ route('employee.leave-requests.create') }}" class="btn btn-primary mb-3">New Leave Request</a>

    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
               <th>S.N</th><th>Type</th><th>Reason</th><th>Dates</th><th>Status</th><th>Admin Comment</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($leaveRequests as $leave_request)
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
        @endforeach
        </tbody>
    </table>
    {{ $leaveRequests->links() }}
</div>
@endsection
