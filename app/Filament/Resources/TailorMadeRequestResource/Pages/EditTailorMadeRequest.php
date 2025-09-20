<?php

namespace App\Filament\Resources\TailorMadeRequestResource\Pages;

use App\Filament\Resources\TailorMadeRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTailorMadeRequest extends EditRecord
{
    protected static string $resource = TailorMadeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
        //    Actions\DeleteAction::make(),
        ];
    }
}
