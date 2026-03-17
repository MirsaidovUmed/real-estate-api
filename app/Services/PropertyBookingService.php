<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Property;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PropertyBookingService
{
    public function book(Property $property, array $data): Booking
    {
        return DB::transaction(function () use ($property, $data) {
            $property = Property::query()
                ->whereKey($property->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (in_array($property->status, ['booked', 'sold'], true)) {
                throw new HttpException(422, 'Property cannot be booked.');
            }

            $booking = Booking::create([
                'property_id' => $property->id,
                'name' => $data['name'],
                'phone' => $data['phone'],
            ]);

            $property->update([
                'status' => 'booked',
            ]);

            return $booking;
        });
    }
}
