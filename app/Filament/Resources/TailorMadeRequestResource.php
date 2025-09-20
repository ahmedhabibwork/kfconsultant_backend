<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TailorMadeRequestResource\Pages;
use App\Filament\Resources\TailorMadeRequestResource\RelationManagers;
use App\Models\TailorMadeRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TailorMadeRequestResource extends Resource
{
    protected static ?string $model = TailorMadeRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationGroup(): ?string
    {
        return __('Requests');
    }
    public static function getNavigationLabel(): string
    {
        return __('Tailor Made Requests');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Tailor Made Requests');
    }

    public static function getModelLabel(): string
    {
        return __('Tailor Made Requests');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label(__('ID'))->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label(__('Phone'))->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->label(__('Email'))->searchable(),

                Tables\Columns\TextColumn::make('duration')->label(__('Duration'))->searchable(),
                Tables\Columns\TextColumn::make('travel_date')->label(__('Travel Date'))->date()->searchable(),
                Tables\Columns\TextColumn::make('preferred_contact_time')->label(__('Contact Time')),
                Tables\Columns\TextColumn::make('ideal_trip_length')->label(__('Ideal Trip Length')),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime('d M, Y H:i:s')
                    ->sortable()
                    ->tooltip(fn($record) => $record->created_at?->format('Y-m-d H:i:s') ?? __('No Date')),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
             //   Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTailorMadeRequests::route('/'),
            // 'create' => Pages\CreateTailorMadeRequest::route('/create'),
            // 'edit' => Pages\EditTailorMadeRequest::route('/{record}/edit'),
        ];
    }
}
