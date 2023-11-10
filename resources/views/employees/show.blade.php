@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Employee Details</h1>

    <div class="card">
        <div class="card-header">
            Employee Information
        </div>
        <div class="card-body">
            <h5 class="card-title">Name: {{ $employee->first_name }} {{ $employee->last_name }}</h5>
            <p class="card-text">Company: {{ $employee->company }}</p>
            <p class="card-text">Email: {{ $employee->email }}</p>
            <p class="card-text">Phone Numbers: {{ is_array($employee->phone_numbers) ? implode(', ', $employee->phone_numbers) : $employee->phone_numbers }}</p>
            <p class="card-text">Dietary Preferences: {{ $employee->dietary_preferences }}</p>
        </div>
    </div>
</div>
@endsection