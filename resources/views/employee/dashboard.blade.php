@extends('employee.layouts.app')

@section('content')
<div class="container">
    <h1>Welcome, {{ Auth::user()->name }}</h1>
    <p>This is the employee dashboard.</p>
</div>
@endsection
