<?php

namespace App\Filament\Host\Resources\Bookings\Pages;

use App\Filament\Host\Resources\Bookings\BookingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;
}
