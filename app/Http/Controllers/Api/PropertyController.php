<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;
use App\Http\Resources\PropertyResource;
use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::query();

        if ($request->filled('city')) {
            $query->where('city', $request->string('city'));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->float('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->float('max_price'));
        }

        if ($request->filled('rooms')) {
            $query->where('rooms', $request->integer('rooms'));
        }

        if ($request->filled('type')) {
            $query->where('type', $request->string('type'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $properties = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return PropertyResource::collection($properties);
    }

    public function store(StorePropertyRequest $request): JsonResponse
    {
        $property = Property::create([
            ...$request->validated(),
            'status' => $request->validated()['status'] ?? 'available',
        ]);

        return (new PropertyResource($property))
            ->response()
            ->setStatusCode(201);
    }

    public function show(Property $property): PropertyResource
    {
        $property->load('bookings');

        return new PropertyResource($property);
    }

    public function update(UpdatePropertyRequest $request, Property $property): PropertyResource
    {
        $property->update($request->validated());

        return new PropertyResource($property);
    }

    public function destroy(Property $property): JsonResponse
    {
        $property->delete();

        return response()->json([
            'message' => 'Property deleted successfully.',
        ]);
    }
}
