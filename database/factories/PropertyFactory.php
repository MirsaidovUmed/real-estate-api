<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Property>
 */
class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition(): array
    {
        $types = ['apartment', 'house', 'commercial'];
        $statuses = ['available', 'booked', 'sold'];

        return [
            'title' => fake()->randomElement([
                '2 комнатная квартира',
                'Частный дом',
                'Коммерческое помещение',
                'Офис в центре',
                '3 комнатная квартира',
            ]),
            'description' => fake()->sentence(12),
            'price' => fake()->randomFloat(2, 30000, 300000),
            'type' => fake()->randomElement($types),
            'city' => fake()->randomElement(['Dushanbe', 'Khujand', 'Bokhtar']),
            'address' => fake()->streetAddress(),
            'rooms' => fake()->numberBetween(1, 6),
            'area' => fake()->randomFloat(2, 25, 300),
            'status' => fake()->randomElement($statuses),
        ];
    }

    public function available(): static
    {
        return $this->state(fn () => [
            'status' => 'available',
        ]);
    }

    public function booked(): static
    {
        return $this->state(fn () => [
            'status' => 'booked',
        ]);
    }

    public function sold(): static
    {
        return $this->state(fn () => [
            'status' => 'sold',
        ]);
    }

    public function apartment(): static
    {
        return $this->state(fn () => [
            'type' => 'apartment',
        ]);
    }

    public function house(): static
    {
        return $this->state(fn () => [
            'type' => 'house',
        ]);
    }

    public function commercial(): static
    {
        return $this->state(fn () => [
            'type' => 'commercial',
        ]);
    }

    public function inDushanbe(): static
    {
        return $this->state(fn () => [
            'city' => 'Dushanbe',
        ]);
    }
}
