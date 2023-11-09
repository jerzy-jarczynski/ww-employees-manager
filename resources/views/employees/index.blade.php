@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Employees</h2>
        <a href="{{ route('employees.create') }}" class="btn btn-success mb-2">Add New Employee</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone Numbers</th>
                    <th>Dietary Preferences</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td>{{ $employee->id }}</td>
                        <td>{{ $employee->first_name }}</td>
                        <td>{{ $employee->last_name }}</td>
                        <td>{{ $employee->company }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>
                            @if(is_array($employee->phone_numbers))
                                {{ implode(', ', $employee->phone_numbers) }}
                            @else
                                {{ $employee->phone_numbers }}
                            @endif
                        </td>
                        <td>{{ $employee->dietary_preferences }}</td>
                        <td>
                            <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
