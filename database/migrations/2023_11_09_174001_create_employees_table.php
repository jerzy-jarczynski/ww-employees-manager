<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Here we define the structure of the 'employees' table using Laravel's Schema builder.
     * We are adding the necessary fields as per the recruitment task specifications.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // Primary key, auto-incrementing
            $table->string('first_name'); // Column for the employee's first name
            $table->string('last_name'); // Column for the employee's last name
            $table->string('company'); // Company name, assumed to be a simple string
            $table->string('email')->unique(); // Employee's email address, must be unique
            $table->json('phone_numbers'); // Column for storing multiple phone numbers, JSON format
            $table->string('dietary_preferences'); // Column for dietary preferences
            $table->softDeletes(); // Column for soft deletes, will store the timestamp of deletion
            $table->timestamps(); // Columns for created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method will drop the 'employees' table if it exists, used when rolling back the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
