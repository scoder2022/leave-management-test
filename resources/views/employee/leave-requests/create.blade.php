@extends('employee.layouts.app')

@section('content')
<div class="container">
    <h2>New Leave Request</h2>

    <form method="POST" action="{{ route('employee.leave-requests.store') }}">
        @csrf
        <!-- Leave Type Dropdown -->
        <label for="leave_type">Leave Type</label>
        <select name="leave_type" id="leave_type" class="form-control" required>
            <option value="">-- Select Leave Type --</option>
            <option value="casual">Casual Leave</option>
            <option value="sick">Sick Leave</option>
            <option value="earned">Earned Leave</option>
            <option value="maternity">Maternity Leave</option>
            <option value="paternity">Paternity Leave</option>
            <option value="unpaid">Unpaid Leave</option>
            <option value="other" {{ old('leave_type') == 'other' ? 'selected' : '' }}>Other</option>
        </select>

        <!-- Custom Input (Hidden by default) -->
        <div id="custom-leave-type-wrapper" style="display:none; margin-top:10px;">
            <label for="custom_leave_type">Other Leave Type</label>
            <input type="text" name="custom_leave_type" id="custom_leave_type" class="form-control"
                value="{{ old('custom_leave_type') }}">
        </div>


        <div class="row">
            <div class="form-group col-md-6">
                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>

            <div class="form-group col-md-6">
                <label>End Date</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
        </div>


        <div class="form-group">
            <label>Reason</label>
            <textarea name="reason" class="form-control" required></textarea>
        </div>

        <button class="btn btn-success mt-2">Submit</button>

    </form>

</div>
@endsection


@push('scripts')
<script>
    const leaveType = document.getElementById('leave_type');
    const customInput = document.getElementById('custom-leave-type-wrapper');

    leaveType.addEventListener('change', () => {
        customInput.style.display = leaveType.value === 'other' ? 'block' : 'none';
    });

    // Show input on load if "Other" was selected previously
    if (leaveType.value === 'other') {
        customInput.style.display = 'block';
    }

</script>

@endpush
