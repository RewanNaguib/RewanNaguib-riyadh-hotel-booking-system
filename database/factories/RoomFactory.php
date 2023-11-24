<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->unique()->numberBetween(100, 999),
            'type' => $this->faker->randomElement(['single', 'double', 'suite']),
            'status' => 'available',
            'price' => $this->faker->randomFloat(2, 50, 300),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
