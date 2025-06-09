@extends('admin.layouts.layout')

@section('content')
<div class="container">
   <h2 class="d-flex justify-content-between align-items-center">
        Edit Leave Request
        <span class="badge
            @if($leaveRequest->status === 'approved') bg-success
            @elseif($leaveRequest->status === 'rejected') bg-danger
            @else bg-primary
            @endif">
            {{ ucfirst($leaveRequest->status) }}
        </span>
    </h2>


    <form method="POST" action="{{ route('admin.leave-requests.status', $leaveRequest->id) }}">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <label for="leave_type">Leave Type</label>
        <select name="leave_type" id="leave_type" class="form-control" required disabled>
            <option value="">-- Select Leave Type --</option>
            <option value="casual" {{ $leaveRequest->leave_type == 'casual' ? 'selected' : '' }}>Casual Leave</option>
            <option value="sick" {{ $leaveRequest->leave_type == 'sick' ? 'selected' : '' }}>Sick Leave</option>
            <option value="earned" {{ $leaveRequest->leave_type == 'earned' ? 'selected' : '' }}>Earned Leave</option>
            <option value="maternity" {{ $leaveRequest->leave_type == 'maternity' ? 'selected' : '' }}>Maternity Leave</option>
            <option value="paternity" {{ $leaveRequest->leave_type == 'paternity' ? 'selected' : '' }}>Paternity Leave</option>
            <option value="unpaid" {{ $leaveRequest->leave_type == 'unpaid' ? 'selected' : '' }}>Unpaid Leave</option>
            <option value="other" {{ !in_array($leaveRequest->leave_type, ['casual','sick','earned','maternity','paternity','unpaid']) ? 'selected' : '' }}>Other</option>
        </select>

        <div id="custom-leave-type-wrapper" style="display:none; margin-top:10px;">
            <label for="custom_leave_type">Other Leave Type</label>
            <input type="text" name="custom_leave_type" id="custom_leave_type" class="form-control"
                disabled   value="{{ !in_array($leaveRequest->leave_type, ['casual','sick','earned','maternity','paternity','unpaid']) ? $leaveRequest->leave_type : '' }}">
        </div>
        <div class="form-group mt-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ $leaveRequest->start_date }}" disabled>
        </div>

        <div class="form-group mt-2">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ $leaveRequest->end_date }}" disabled>
        </div>

        <div class="form-group mt-2">
            <label>Reason</label>
            <textarea name="reason" class="form-control" disabled>{{ $leaveRequest->reason }}</textarea>
        </div>

        <hr>

        <div class="form-group mt-2">
            <label>Admin Comment</label>
            <textarea name="admin_comment" class="form-control" required>{{ $leaveRequest->admin_comment }}</textarea>
        </div>

        <label for="status">Leave Status</label>
        <select name="status" id="status" class="form-control" required>
            <option value="">-- Select Leave Status --</option>
            <option value="approved" {{ $leaveRequest->status == 'approved' ? 'selected' : '' }}>Approve</option>
            <option value="rejected" {{ $leaveRequest->status == 'rejected' ? 'selected' : '' }}>Reject</option>
        </select>

        <button class="btn btn-primary mt-3">Update</button>

    </form>
</div>
@endsection


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const leaveType = document.getElementById('leave_type');
        const customWrapper = document.getElementById('custom-leave-type-wrapper');

        const showCustomField = () => {
            if (leaveType.value === 'other') {
                customWrapper.style.display = 'block';
            } else {
                customWrapper.style.display = 'none';
            }
        };

        // Run once on load
        showCustomField();

        // Update on change
        leaveType.addEventListener('change', showCustomField);
    });
</script>
@endpush
