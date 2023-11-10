@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Add New Employee</h1>
    <form action="{{ route('employees.store') }}" method="POST" id="createForm"> {{-- Dodano id do formularza --}}
        @csrf

        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>

        <div class="mb-3">
            <label for="company" class="form-label">Company</label>
            <input type="text" class="form-control" id="company" name="company" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="phone_numbers" class="form-label">Phone Numbers</label>
            <div id="phone_numbers">
                <div class="input-group mb-2">
                    <input type="tel" class="form-control" name="phone_numbers[]" placeholder="Enter phone number" required>
                    <button class="btn btn-outline-secondary" type="button" onclick="addPhoneNumber()">+</button>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="dietary_preferences" class="form-label">Dietary Preferences</label>
            <select class="form-control" id="dietary_preferences" name="dietary_preferences" required>
                <option value="">Choose...</option>
                <option value="none">None</option>
                <option value="vegetarian">Vegetarian</option>
                <option value="vegan">Vegan</option>
            </select>
        </div>

        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmationModal">Submit</button>
    </form>

    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to add this employee?
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
    document.getElementById('confirmButton').addEventListener('click', () => {
        const form = document.getElementById('createForm');
        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                if (response.status === 422) {
                    return response.json().then(errors => {
                        const errorMessages = Object.values(errors.errors).map(err => err.join(', ')).join('\n');
                        throw new Error('Validation failed: ' + errorMessages);
                    });
                }
                throw new Error('Server responded with a status: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                setTimeout(() => {
                    window.location.href = '/';
                }, 1500);
            } else {
                alert('An error occurred while processing the form.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred: ' + error.message);
        });
    });
</script>

<script>
    function addPhoneNumber() {
        const phoneNumbersDiv = document.getElementById('phone_numbers');
        const newPhoneNumberInput = document.createElement('div');
        newPhoneNumberInput.classList.add('input-group', 'mb-2');
        newPhoneNumberInput.innerHTML = `
            <input type="tel" class="form-control" name="phone_numbers[]" placeholder="Enter phone number" required>
            <button class="btn btn-outline-danger" type="button" onclick="removePhoneNumber(this)">-</button>
        `;
        phoneNumbersDiv.appendChild(newPhoneNumberInput);
    }

    function removePhoneNumber(button) {
        button.closest('.input-group').remove();
    }
</script>
@endsection
