<?php

namespace Database\Factories;

use App\Models\Ticker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Metadata>
 */
class MetadataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ticker' => Ticker::factory(),
            'json' => fake()->realText(),
        ];
    }
}
