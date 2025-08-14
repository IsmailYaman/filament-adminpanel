<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Conference;
use App\Models\Venue;
use App\Enums\Region;
use App\Enums\Status;
use App\Models\Speaker;

class ConferenceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Conference::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('now', '+1 year');
        $endDate = fake()->dateTimeBetween($startDate, '+1 year');
        return [
            'name' => fake()->name(),
            'description' => fake()->text(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => fake()->randomElement(Status::class),
            'region' => fake()->randomElement(Region::class),
            'venue_id' => null,
            'speakers' => Speaker::query()->inRandomOrder()->limit(3)->pluck('id')->all(),
        ];
    }
}
        