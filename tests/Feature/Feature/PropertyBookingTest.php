<?php

namespace Tests\Feature\Feature;

use App\Models\Property;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyBookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_available_property_can_be_booked(): void
    {
        $property = Property::factory()->available()->create();

        $payload = [
            'name' => 'Ali',
            'phone' => '+992900000000',
        ];

        $response = $this->postJson("/api/properties/{$property->id}/book", $payload);

        $response
            ->assertCreated()
            ->assertJsonPath('data.property_id', $property->id)
            ->assertJsonPath('data.name', 'Ali')
            ->assertJsonPath('data.phone', '+992900000000');

        $this->assertDatabaseHas('bookings', [
            'property_id' => $property->id,
            'name' => 'Ali',
            'phone' => '+992900000000',
        ]);

        $this->assertDatabaseHas('properties', [
            'id' => $property->id,
            'status' => 'booked',
        ]);
    }

    public function test_booked_property_cannot_be_booked(): void
    {
        $property = Property::factory()->booked()->create();

        $response = $this->postJson("/api/properties/{$property->id}/book", [
            'name' => 'Ali',
            'phone' => '+992900000000',
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'Property cannot be booked.',
            ]);

        $this->assertDatabaseMissing('bookings', [
            'property_id' => $property->id,
            'name' => 'Ali',
        ]);
    }

    public function test_sold_property_cannot_be_booked(): void
    {
        $property = Property::factory()->sold()->create();

        $response = $this->postJson("/api/properties/{$property->id}/book", [
            'name' => 'Ali',
            'phone' => '+992900000000',
        ]);

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'Property cannot be booked.',
            ]);

        $this->assertDatabaseMissing('bookings', [
            'property_id' => $property->id,
            'name' => 'Ali',
        ]);
    }
}
