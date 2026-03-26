<?php

namespace App\Models;

use App\Enums\PropertyStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'type',
        'city',
        'address',
        'rooms',
        'area',
        'status',
    ];

    protected $casts = [
        'status' => PropertyStatus::class,
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
