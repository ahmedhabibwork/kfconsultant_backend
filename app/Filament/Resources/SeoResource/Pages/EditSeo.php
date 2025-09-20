<?php

namespace App\Filament\Resources\SeoResource\Pages;

use App\Filament\Resources\SeoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeo extends EditRecord
{
    protected static string $resource = SeoResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
    protected function getHeaderActions(): array
    {
        return [
         //   Actions\DeleteAction::make(),
        ];
    }
}
