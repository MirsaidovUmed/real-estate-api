<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookPropertyRequest;
use App\Http\Resources\BookingResource;
use App\Models\Property;
use App\Services\PropertyBookingService;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller
{
    public function __construct(
        private readonly PropertyBookingService $propertyBookingService
    ) {}

    public function store(BookPropertyRequest $request, Property $property): JsonResponse
    {
        $booking = $this->propertyBookingService->book($property, $request->validated());

        return (new BookingResource($booking))
            ->response()
            ->setStatusCode(201);
    }
}
