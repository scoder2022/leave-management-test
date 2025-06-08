@extends('employee.layouts.app')

@section('content')
<div class="container">
   <h2 class="d-flex justify-content-between align-items-center">
        Edit Leave Request
        <span class="badge
            @if($leaveRequest->status === 'approved') bg-success
            @elseif($leaveRequest->status === 'rejected') bg-danger
            @else bg-primary
            @endif">{{ ucfirst($leaveRequest->status) }}
        </span>
    </h2>


    <form method="POST" action="{{ route('employee.leave-requests.update', $leaveRequest->id) }}">
        @csrf
        @method('PUT')

        <!-- Leave Type Dropdown -->
        <label for="leave_type">Leave Type</label>
        <select name="leave_type" id="leave_type" class="form-control" required>
            <option value="">-- Select Leave Type --</option>
            <option value="casual" {{ $leaveRequest->leave_type == 'casual' ? 'selected' : '' }}>Casual Leave</option>
            <option value="sick" {{ $leaveRequest->leave_type == 'sick' ? 'selected' : '' }}>Sick Leave</option>
            <option value="earned" {{ $leaveRequest->leave_type == 'earned' ? 'selected' : '' }}>Earned Leave</option>
            <option value="maternity" {{ $leaveRequest->leave_type == 'maternity' ? 'selected' : '' }}>Maternity Leave</option>
            <option value="paternity" {{ $leaveRequest->leave_type == 'paternity' ? 'selected' : '' }}>Paternity Leave</option>
            <option value="unpaid" {{ $leaveRequest->leave_type == 'unpaid' ? 'selected' : '' }}>Unpaid Leave</option>
            <option value="other" {{ !in_array($leaveRequest->leave_type, ['casual','sick','earned','maternity','paternity','unpaid']) ? 'selected' : '' }}>Other</option>
        </select>

        <!-- Custom Leave Type Field -->
        <div id="custom-leave-type-wrapper" style="display:none; margin-top:10px;">
            <label for="custom_leave_type">Other Leave Type</label>
            <input type="text" name="custom_leave_type" id="custom_leave_type" class="form-control"
                   value="{{ !in_array($leaveRequest->leave_type, ['casual','sick','earned','maternity','paternity','unpaid']) ? $leaveRequest->leave_type : '' }}">
        </div>

        <div class="form-group mt-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" value="{{ $leaveRequest->start_date }}" required>
        </div>

        <div class="form-group mt-2">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" value="{{ $leaveRequest->end_date }}" required>
        </div>

        <div class="form-group mt-2">
            <label>Reason</label>
            <textarea name="reason" class="form-control" required>{{ $leaveRequest->reason }}</textarea>
        </div>

        <button class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const leaveType = document.getElementById('leave_type');
    const customInput = document.getElementById('custom-leave-type-wrapper');
    const customField = document.getElementById('custom_leave_type');

    function toggleCustomInput() {
        if (leaveType.value === 'other') {
            customInput.style.display = 'block';
        } else {
            customInput.style.display = 'none';
            customField.value = '';
        }
    }

    leaveType.addEventListener('change', toggleCustomInput);

    // Initialize on load
    toggleCustomInput();
</script>
@endpush
