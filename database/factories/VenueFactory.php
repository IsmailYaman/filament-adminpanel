<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Venue;
use App\Enums\Region;

class VenueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Venue::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'postal_code' => fake()->postcode(),
            'region' => fake()->randomElement(Region::class),   
        ];  
    }
}
