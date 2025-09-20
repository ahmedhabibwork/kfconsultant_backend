<?php

namespace App\Filament\Resources\FlightBookingResource\Pages;

use App\Filament\Resources\FlightBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFlightBookings extends ListRecords
{
    protected static string $resource = FlightBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
          //  Actions\CreateAction::make(),
        ];
    }
}
