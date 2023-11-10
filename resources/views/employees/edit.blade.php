@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Edit Employee</h1>

    <form action="{{ route('employees.update', ['employee' => $employee->id]) }}" method="POST" id="editForm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $employee->first_name) }}" required>
            <div class="invalid-feedback">First name is required.</div>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $employee->last_name) }}" required>
            <div class="invalid-feedback">Last name is required.</div>
        </div>

        <div class="mb-3">
            <label for="company" class="form-label">Company</label>
            <select class="form-control" id="company" name="company" required>
                <option value="Company A" {{ old('company', $employee->company) === 'Company A' ? 'selected' : '' }}>Company A</option>
                <option value="Company B" {{ old('company', $employee->company) === 'Company B' ? 'selected' : '' }}>Company B</option>
            </select>
            <div class="invalid-feedback">Company is required.</div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $employee->email) }}" required>
            <div class="invalid-feedback">Please provide a valid email.</div>
        </div>

        <div class="mb-3">
            <label for="phone_numbers" class="form-label">Phone Numbers</label>
            <input type="text" class="form-control" id="phone_numbers" name="phone_numbers" value="{{ is_array(old('phone_numbers')) ? implode(', ', old('phone_numbers')) : old('phone_numbers', implode(', ', $employee->phone_numbers)) }}" required>
            <div class="invalid-feedback">Phone number is required.</div>
        </div>

        <div class="mb-3">
            <label for="dietary_preferences" class="form-label">Dietary Preferences</label>
            <select class="form-control" id="dietary_preferences" name="dietary_preferences" required>
                <option value="Vegetarian" {{ old('dietary_preferences', $employee->dietary_preferences) === 'Vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                <option value="Vegan" {{ old('dietary_preferences', $employee->dietary_preferences) === 'Vegan' ? 'selected' : '' }}>Vegan</option>
                <option value="Non-Vegetarian" {{ old('dietary_preferences', $employee->dietary_preferences) === 'Non-Vegetarian' ? 'selected' : '' }}>Non-Vegetarian</option>
            </select>
            <div class="invalid-feedback">Dietary preference is required.</div>
        </div>

        <button type="button" class="btn btn-primary" id="submitButton">Save Changes</button>
    </form>

    {{-- Confirmation Modal --}}
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Changes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to save these changes?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmButton">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('submitButton').addEventListener('click', function(event) {
        event.preventDefault();
        let isFormValid = validateForm();

        if (isFormValid) {
            const confirmationModalElement = document.getElementById('confirmationModal');
            const confirmationModal = bootstrap.Modal.getOrCreateInstance(confirmationModalElement);
            confirmationModal.show();
        }
    });

    document.getElementById('confirmButton').addEventListener('click', () => {
        const form = document.getElementById('editForm');
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(handleResponse)
        .catch(handleError);

        const confirmationModalElement = document.getElementById('confirmationModal');
        const confirmationModal = bootstrap.Modal.getOrCreateInstance(confirmationModalElement);
        confirmationModal.hide();
    });

    function validateForm() {
        let isFormValid = true;
        // Validation logic for each field
        ['first_name', 'last_name', 'company', 'email', 'phone_numbers', 'dietary_preferences'].forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isFormValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        // Additional validation for email format
        const emailField = document.getElementById('email');
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailField.value.trim())) {
            emailField.classList.add('is-invalid');
            isFormValid = false;
        } else {
            emailField.classList.remove('is-invalid');
        }

        return isFormValid;
    }

    function handleResponse(response) {
        if (!response.ok) {
            if (response.status === 422) {
                return response.json().then(errors => {
                    const errorMessages = Object.values(errors.errors).map(err => err.join(', ')).join('\n');
                    throw new Error('Validation failed: ' + errorMessages);
                });
            }
            throw new Error('Server responded with a status: ' + response.status);
        }
        return response.json().then(data => {
            if (data.success) {
                alert('Employee updated successfully.');
                window.location.href = '/';
            } else {
                alert('An error occurred while processing the form.');
            }
        });
    }

    function handleError(error) {
        console.error('Error:', error);
        alert('An error occurred: ' + error.message);
    }
</script>
@endsection
