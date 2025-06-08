@extends('admin.layouts.layout')

@section('content')
<div class="container">
   <h2 class="d-flex justify-content-between align-items-center">
    Edit User Employee
</h2>


    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{$user->id}}">

        <div class="form-group">
            <label>Employee Full Name</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control" placeholder="Employee Full Name" required >
        </div>

        <div class="form-group">
            <label>Employee E-Mail</label>
            <input type="text" name="email" value="{{ $user->email }}" class="form-control" placeholder="Employee Email Address" required >
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
            <option value="" selected disabled>-- Select User Status--</option>
            <option value="1" @selected($user->status === 1)>Active</option>
            <option value="0" @selected($user->status === 0)>In-Active</option>
        </select>

        <button class="btn btn-success mt-2">Update</button>
    </form>
</div>
@endsection
