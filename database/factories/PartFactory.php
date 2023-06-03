<?php

namespace Database\Factories;

use App\Models\Part;
use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartFactory extends Factory
{

    public function definition()
    {
        $carIdArray = Car::pluck('id')->toArray();

        return [
            'name' => 'Part ' . $this->faker->colorName(),
            'serialnumber' => $this->faker->unique()->numerify('SN-#####'),
            'car_id' => $this->faker->randomElement($carIdArray),
        ];
    }
}
