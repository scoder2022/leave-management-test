@extends('admin.layouts.layout')

@push('css')
<style>

</style>
@endpush

@section('content')
<div class="container">
    <h2>All Users</h2>
   <a href="{{ route('admin.users.create') }}" class="btn btn-outline-primary mb-3" style="float:right">
            Add New User/Employee
        </a>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>S.N</th>
                <th>Names</th>
                <th>E-Mail</th>
                <th>Created Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
                <td>
                    <span class="font-weight-bold {{ $user->status ? 'text-success' : 'text-danger' }}">
                        {{ $user->status ? 'Active' : 'In-Active' }}
                    </span>

                </td>
                <td>
                    <div class="action">
                        <a href="{{ route('admin.users.show', $user->id) }}" title="Show User Detail"
                            class="btn btn-sm btn-info mt-4">
                            <i class="fa fa-eye"></i> Show
                        </a>
                        <a href="{{ route('admin.users.edit', $user->id) }}" title="Edit User Detail"
                            class="btn btn-sm btn-info mt-4">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure to delete this User?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger mt-4">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
</div>
@endsection
