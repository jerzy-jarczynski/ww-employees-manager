@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Edit Employee</h1>

    <form action="{{ route('employees.update', ['employee' => $employee->id]) }}" method="POST" id="editForm">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $employee->first_name) }}">
        </div>

        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $employee->last_name) }}">
        </div>

        <div class="form-group">
            <label for="company">Company</label>
            <select class="form-control" id="company" name="company">
                <option value="Company A" {{ old('company', $employee->company) === 'Company A' ? 'selected' : '' }}>Company A</option>
                <option value="Company B" {{ old('company', $employee->company) === 'Company B' ? 'selected' : '' }}>Company B</option>
            </select>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $employee->email) }}">
        </div>

        <div class="form-group">
            <label for="phone_numbers">Phone Numbers</label>
            <input type="text" class="form-control" id="phone_numbers" name="phone_numbers" value="{{ is_array(old('phone_numbers')) ? implode(', ', old('phone_numbers')) : old('phone_numbers', implode(', ', $employee->phone_numbers)) }}">
        </div>

        <div class="form-group">
            <label for="dietary_preferences">Dietary Preferences</label>
            <select class="form-control" id="dietary_preferences" name="dietary_preferences">
                <option value="Vegetarian" {{ old('dietary_preferences', $employee->dietary_preferences) === 'Vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                <option value="Vegan" {{ old('dietary_preferences', $employee->dietary_preferences) === 'Vegan' ? 'selected' : '' }}>Vegan</option>
                <option value="Non-Vegetarian" {{ old('dietary_preferences', $employee->dietary_preferences) === 'Non-Vegetarian' ? 'selected' : '' }}>Non-Vegetarian</option>
            </select>
        </div>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmationModal">Save Changes</button>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this employee?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
        let employeeIdToDelete;

        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', () => {
                employeeIdToDelete = button.getAttribute('data-employee-id');
                deleteConfirmationModal.show();
            });
        });

        document.getElementById('confirmDeleteButton').addEventListener('click', () => {
            fetch(`/employees/${employeeIdToDelete}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`employee-${employeeIdToDelete}`).remove();
                } else {
                    throw new Error('An error occurred while processing the deletion.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred: ' + error.message);
            });

            deleteConfirmationModal.hide();
        });
    });
</script>
@endsection
