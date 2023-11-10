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
                <th><a href="{{ route('employees.index', ['sort_by' => 'first_name', 'sort_order' => request('sort_by') === 'first_name' && request('sort_order') === 'asc' ? 'desc' : 'asc']) }}">First Name</a></th>
                <th><a href="{{ route('employees.index', ['sort_by' => 'last_name', 'sort_order' => request('sort_by') === 'last_name' && request('sort_order') === 'asc' ? 'desc' : 'asc']) }}">Last Name</a></th>
                <th><a href="{{ route('employees.index', ['sort_by' => 'company', 'sort_order' => request('sort_by') === 'company' && request('sort_order') === 'asc' ? 'desc' : 'asc']) }}">Company</a></th>
                <th><a href="{{ route('employees.index', ['sort_by' => 'email', 'sort_order' => request('sort_by') === 'email' && request('sort_order') === 'asc' ? 'desc' : 'asc']) }}">Email</a></th>
                <th>Phone Numbers</th>
                <th>Dietary Preferences</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
            <tr>
                <td>{{ $employee->first_name }}</td>
                <td>{{ $employee->last_name }}</td>
                <td>{{ $employee->company }}</td>
                <td>{{ $employee->email }}</td>
                <td>{{ is_array($employee->phone_numbers) ? implode(', ', $employee->phone_numbers) : $employee->phone_numbers }}</td>
                <td>{{ $employee->dietary_preferences }}</td>
                <td>
                    <a href="{{ route('employees.edit', ['employee' => $employee->id]) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('employees.destroy', ['employee' => $employee->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        {{ $employees->appends(['sort_by' => request('sort_by'), 'sort_order' => request('sort_order')])->links('vendor.pagination.bootstrap-5') }}
    </div>
</div>
@endsection
