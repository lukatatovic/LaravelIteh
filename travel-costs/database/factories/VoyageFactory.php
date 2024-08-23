<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voyage>
 */
class VoyageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'destination' => fake()->city(),
            'arrival' => fake()->dateTimeBetween('-90days', 'now'),
            'departure' => fake()->dateTimeBetween('now', '+10days'),
            'transportation' => fake()->randomElement([
                'airplane', 'bus', 'car', 'train',
                'boat', 'carriage'
            ]),
            'total_cost' => 0
        ];
    }
}
