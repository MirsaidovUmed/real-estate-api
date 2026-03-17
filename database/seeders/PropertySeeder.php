<?php

namespace Database\Seeders;

use App\Models\Property;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        Property::factory()->count(10)->available()->create();

        Property::factory()->count(5)->booked()->create();

        Property::factory()->count(3)->sold()->create();

        Property::factory()->available()->apartment()->inDushanbe()->create([
            'title' => '2 комнатная квартира в центре',
            'description' => 'Хороший ремонт, рядом транспорт',
            'price' => 85000,
            'address' => 'Rudaki 12',
            'rooms' => 2,
            'area' => 65,
        ]);

        Property::factory()->available()->house()->inDushanbe()->create([
            'title' => 'Частный дом',
            'description' => 'Дом с участком',
            'price' => 150000,
            'address' => 'Somoni 45',
            'rooms' => 4,
            'area' => 180,
        ]);

        Property::factory()->commercial()->create([
            'title' => 'Офисное помещение',
            'description' => 'Подходит под бизнес',
            'price' => 120000,
            'city' => 'Khujand',
            'address' => 'Central Avenue 10',
            'rooms' => 3,
            'area' => 110,
            'status' => 'available',
        ]);
    }
}
