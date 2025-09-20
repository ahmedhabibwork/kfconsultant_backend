<?php

namespace App\Filament\Resources\FlightBookingResource\Pages;

use App\Filament\Resources\FlightBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFlightBooking extends EditRecord
{
    protected static string $resource = FlightBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
         //   Actions\DeleteAction::make(),
        ];
    }
}
