<?php

namespace Database\Factories;

use App\Models\TouristDestination;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<TouristDestination>
 */
class TouristDestinationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->city() . ' Landmark';

        return [
            'name'              => $name,
            'slug'              => Str::slug($name) . '-' . Str::random(5),
            'category'          => fake()->randomElement(['falls_nature', 'boulevard', 'seashore', 'cafe', 'hotel', 'church_heritage']),
            'short_description' => fake()->sentence(),
            'description'       => fake()->paragraph(),
            'address'           => fake()->address(),
            'city_municipality' => 'Balingasag',
            'province'          => 'Misamis Oriental',
            'latitude'          => fake()->latitude(8.7, 8.8),
            'longitude'         => fake()->longitude(124.7, 124.8),
            'cover_image'       => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e',
            'is_published'      => true,
            'created_by'        => User::factory(),
        ];
    }

    /**
     * Indicate that the destination is unpublished / draft.
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }
}
