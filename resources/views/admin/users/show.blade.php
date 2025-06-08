@extends('admin.layouts.layout')

@section('content')
<div class="container">
    <h2 class="mb-4">User Details</h2>

    <div class="card">
        <div class="card-body">

            <div class="mb-3">
                <strong>Name:</strong> {{ $user->name }}
            </div>

            <div class="mb-3">
                <strong>Email:</strong> {{ $user->email }}
            </div>
            <div class="mb-3">
                <strong>Status:</strong> <span
                    class="font-weight-bold {{ $user->status ? 'text-success' : 'text-danger' }}">
                    {{ $user->status ? 'Active' : 'In-Active' }}
                </span>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection
