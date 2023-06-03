<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{

    public function definition(): array
    {
        $isRegistered = $this->faker->boolean;
        $registrationNumber = ($isRegistered ? $this->faker->unique()->randomNumber(6) : null);

        return [
            'name' => 'Car ' . $this->faker->colorName(),
            'registration_number' => $registrationNumber,
            'is_registered' => $isRegistered,
        ];
    }
}
