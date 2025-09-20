<?php

namespace App\Filament\Resources;

use App\Enums\RoomTypeEnum;
use App\Filament\Resources\HotelBookingResource\Pages;
use App\Filament\Resources\HotelBookingResource\RelationManagers;
use App\Models\HotelBooking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HotelBookingResource extends Resource
{
    protected static ?string $model = HotelBooking::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationGroup(): ?string
    {
        return __('Requests');
    }
    public static function getNavigationLabel(): string
    {
        return __('Hotel Booking Requests');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Hotel Booking Requests');
    }

    public static function getModelLabel(): string
    {
        return __('Hotel Booking Requests');
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
                Tables\Columns\TextColumn::make('name')->label(__('Full Name'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->label(__('Email'))->searchable(),
                Tables\Columns\TextColumn::make('phone')->label(__('Phone'))->searchable(),
                Tables\Columns\TextColumn::make('country')->label(__('Country'))->sortable(),

                Tables\Columns\TextColumn::make('arrival_date')->label(__('Arrival Date'))->date()->sortable(),
                Tables\Columns\TextColumn::make('departure_date')->label(__('Departure Date'))->date()->sortable(),

                Tables\Columns\TextColumn::make('people_count')->label(__('People Count')),

                Tables\Columns\BadgeColumn::make('room_type')
                    ->label(__('Room Type'))
                    ->formatStateUsing(fn(?RoomTypeEnum $state) => $state?->label())
                    ->colors(fn(?RoomTypeEnum $state) => [
                        $state?->color() => $state?->value,
                    ]),

            ])->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('room_type')
                    ->label(__('Room Type'))
                    ->options(
                        collect(RoomTypeEnum::cases())
                            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
                    ),
            ])
            ->actions([
                //  Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListHotelBookings::route('/'),
            'create' => Pages\CreateHotelBooking::route('/create'),
            'edit' => Pages\EditHotelBooking::route('/{record}/edit'),
        ];
    }
}
