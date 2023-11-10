@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Edit Employee</h1>

    <form action="{{ route('employees.update', ['employee' => $employee->id]) }}" method="POST">
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

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</div>
@endsection
