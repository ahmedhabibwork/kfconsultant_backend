<?php

namespace App\Filament\Resources\TailorMadeRequestResource\Pages;

use App\Filament\Resources\TailorMadeRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTailorMadeRequests extends ListRecords
{
    protected static string $resource = TailorMadeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
       //     Actions\CreateAction::make(),
        ];
    }
}
