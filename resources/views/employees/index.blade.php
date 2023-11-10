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

    <!-- Wrap the table in a div with horizontal scroll -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
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
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteConfirmationModal" onclick="setDeleteAction('{{ route('employees.destroy', ['employee' => $employee->id]) }}')">Delete</button>
                        </form>
                        <a href="{{ route('employees.show', ['employee' => $employee->id]) }}" class="btn btn-success">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        {{ $employees->appends(['sort_by' => request('sort_by'), 'sort_order' => request('sort_order')])->links('vendor.pagination.bootstrap-5') }}
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this employee?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function setDeleteAction(action) {
        document.getElementById('deleteForm').action = action;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const action = deleteForm.action;
            
            fetch(action, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    setTimeout(function () {
                        window.location.href = "{{ route('employees.index') }}";
                    }, 1500);
                }
            })
            .catch(error => {
                console.error(error);
            });
        });
    });
</script>
@endsection
