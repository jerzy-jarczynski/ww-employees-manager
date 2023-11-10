{{-- resources/views/employees/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Add New Employee</h1>
    <form action="{{ route('employees.store') }}" method="POST">
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
                <!-- Dodaj więcej opcji zgodnie z wymaganiami -->
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

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
