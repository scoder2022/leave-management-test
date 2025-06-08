@extends('admin.layouts.layout')

@section('content')
<div class="container">
    <h2 class="mb-4">Leave Request Details</h2>

    <div class="card">
        <div class="card-body">

            <!-- Status Badge -->
            <div class="mb-3">
                <strong>Status:</strong>
                <span class="font-weight-bold
                    @if($leaveRequest->status === 'approved') text-success
                    @elseif($leaveRequest->status === 'rejected') text-danger
                    @else text-primary
                    @endif"> {{ ucfirst($leaveRequest->status) }}
                </span>
            </div>

            <div class="mb-3">
                <strong>Leave Type:</strong> {{ $leaveRequest->leave_type }}
            </div>

            <div class="mb-3">
                <strong>Start Date:</strong> {{ \Carbon\Carbon::parse($leaveRequest->start_date)->format('F d, Y') }}
            </div>

            <div class="mb-3">
                <strong>End Date:</strong> {{ \Carbon\Carbon::parse($leaveRequest->end_date)->format('F d, Y') }}
            </div>

            <div class="mb-3">
                <strong>Reason:</strong>
                <p>{{ $leaveRequest->reason }}</p>
            </div>
            <hr>
            <div class="mb-3">
                <form method="POST" action="{{ route('admin.leave-requests.status', $leaveRequest->id) }}">
                    @csrf
                <label for="status">Leave Status</label>
                <select name="status" id="status" class="form-control" required>
                    <option selected disabled>-- Select Leave Status --</option>
                    <option value="approved" {{ $leaveRequest->status == 'approved' ? 'selected' : '' }}>Approve</option>
                    <option value="rejected" {{ $leaveRequest->status == 'rejected' ? 'selected' : '' }}>Reject</option>
                </select>

                    <strong>Admin Comment:</strong>
                    <textarea name="admin_comment" class="form-control mt-2" rows="3"
                    placeholder="Add or update a comment...">{{ old('admin_comment', $leaveRequest->admin_comment) }}</textarea>

                    <button type="submit" class="btn btn-sm btn-primary mt-2">Save</button>

                </form>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.leave-requests.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection
