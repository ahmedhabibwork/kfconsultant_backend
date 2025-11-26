<?php

namespace App\Filament\Resources\ScopeResource\Pages;

use App\Filament\Resources\ScopeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateScope extends CreateRecord
{
    protected static string $resource = ScopeResource::class;
        protected function getRedirectUrl(): string
    {
        return $this->previousUrl ?? $this->getResource()::getUrl('index');
    }
}
