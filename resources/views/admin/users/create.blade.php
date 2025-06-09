@extends('admin.layouts.layout')

@section('content')
<div class="container">
    <h2>Add New Employee</h2>

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf

        <!-- User Dropdown -->

        <div class="form-group">
            <label>Employee Full Name</label>
            <input type="text" name="name" class="form-control" placeholder="Employee Full Name" required >
        </div>

        <div class="form-group">
            <label>Employee E-Mail</label>
            <input type="text" name="email" class="form-control" placeholder="Employee Email Address" required >
        </div>

         <div class="form-group">
            <label>Password</label>
             <input type="password" name="password" class="form-control" id="password" placeholder="Password">
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input value="{{ old('password_confirmation') }}" type="password" placeholder="Confirm Password"
                class="form-control" name="password_confirmation">
        </div>

        <label for="status">Status</label>
        <select name="status" id="status" class="form-control" required>
            <option value="">-- Select User Status--</option>
            <option value="1" selected>Active</option>
            <option value="0">In-Active</option>
        </select>

        <button class="btn btn-success mt-2">Submit</button>
    </form>
</div>
@endsection
