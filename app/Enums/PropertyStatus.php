<?php

namespace App\Enums;

enum PropertyStatus: string
{
    case AVAILABLE = 'available';
    case BOOKED = 'booked';
    case SOLD = 'sold';

    public function canBeBooked(): bool
    {
        return $this === self::AVAILABLE;
    }
}
