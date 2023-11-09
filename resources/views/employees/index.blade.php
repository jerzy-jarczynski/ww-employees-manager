@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Employee List</h1>

    <form action="{{ route('employees.index') }}" method="GET">
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="search" placeholder="Search employees" value="{{ request('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>

    <table class="table table-striped table-bordered table-responsive">
        <thead class="table-primary">
            <tr>
                <th><a href="{{ route('employees.index', ['sort_by' => 'first_name']) }}">First Name</a></th>
                <th><a href="{{ route('employees.index', ['sort_by' => 'last_name']) }}">Last Name</a></th>
                <th><a href="{{ route('employees.index', ['sort_by' => 'company']) }}">Company</a></th>
                <th><a href="{{ route('employees.index', ['sort_by' => 'email']) }}">Email</a></th>
                <th>Phone Numbers</th>
                <th>Dietary Preferences</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr>
                <td>{{ $employee->first_name }}</td>
                <td>{{ $employee->last_name }}</td>
                <td>{{ $employee->company }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ implode(', ', $employee->phone_numbers) }}</td>
                <td>{{ $employee->dietary_preferences }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        {{ $employees->links() }}
    </div>
</div>
@endsection
