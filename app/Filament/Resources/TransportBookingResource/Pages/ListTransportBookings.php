<?php

namespace App\Filament\Resources\TransportBookingResource\Pages;

use App\Filament\Resources\TransportBookingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransportBookings extends ListRecords
{
    protected static string $resource = TransportBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
         //   Actions\CreateAction::make(),
        ];
    }
}
