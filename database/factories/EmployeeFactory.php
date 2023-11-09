<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'company' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'phone_numbers' => json_encode([$this->faker->phoneNumber]),
            'dietary_preferences' => $this->faker->randomElement(['Wegańskie', 'Wegetariańskie', 'Bezglutenowe', 'Standardowe']),
        ];
    }
}
