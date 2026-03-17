<?php

namespace Tests\Feature\Feature;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_property_creation_requires_required_fields(): void
    {
        $response = $this->postJson('/api/properties', []);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors([
                'title',
                'description',
                'price',
                'type',
                'city',
                'address',
                'rooms',
                'area',
            ]);
    }

    public function test_show_returns_404_for_missing_property(): void
    {
        $response = $this->getJson('/api/properties/999999');

        $response->assertNotFound();
    }

    public function test_property_can_be_created(): void
    {
        $payload = [
            'title' => '2 комнатная квартира',
            'description' => 'Хороший ремонт',
            'price' => 85000,
            'type' => 'apartment',
            'city' => 'Dushanbe',
            'address' => 'Rudaki 12',
            'rooms' => 2,
            'area' => 65,
        ];

        $response = $this->postJson('/api/properties', $payload);

        $response
            ->assertCreated()
            ->assertJsonPath('data.title', '2 комнатная квартира')
            ->assertJsonPath('data.status', 'available');

        $this->assertDatabaseHas('properties', [
            'title' => '2 комнатная квартира',
            'city' => 'Dushanbe',
            'type' => 'apartment',
            'status' => 'available',
        ]);
    }

    public function test_properties_can_be_filtered(): void
    {
        Property::factory()->create([
            'city' => 'Dushanbe',
            'type' => 'apartment',
            'rooms' => 2,
            'price' => 80000,
            'status' => 'available',
        ]);

        Property::factory()->create([
            'city' => 'Dushanbe',
            'type' => 'apartment',
            'rooms' => 3,
            'price' => 95000,
            'status' => 'available',
        ]);

        Property::factory()->create([
            'city' => 'Khujand',
            'type' => 'house',
            'rooms' => 2,
            'price' => 80000,
            'status' => 'available',
        ]);

        $response = $this->getJson('/api/properties?city=Dushanbe&type=apartment&rooms=2&min_price=50000&max_price=90000');

        $response
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.city', 'Dushanbe')
            ->assertJsonPath('data.0.type', 'apartment')
            ->assertJsonPath('data.0.rooms', 2);
    }
}
