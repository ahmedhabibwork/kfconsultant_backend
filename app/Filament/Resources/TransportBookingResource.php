<?php

namespace App\Filament\Resources;

use App\Enums\CarTypeEnum;
use App\Filament\Resources\TransportBookingResource\Pages;
use App\Filament\Resources\TransportBookingResource\RelationManagers;
use App\Models\TransportBooking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransportBookingResource extends Resource
{
    protected static ?string $model = TransportBooking::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationGroup(): ?string
    {
        return __('Requests');
    }
    public static function getNavigationLabel(): string
    {
        return __('Transport Booking Requests');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Transport Booking Requests');
    }

    public static function getModelLabel(): string
    {
        return __('Transport Booking Requests');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('Full Name'))->searchable(),
                Tables\Columns\TextColumn::make('email')->label(__('Email'))->searchable(),
                Tables\Columns\TextColumn::make('phone')->label(__('Phone')),
                Tables\Columns\TextColumn::make('destination')->label(__('Destination')),
                Tables\Columns\TextColumn::make('trip_date')->label(__('Trip Date'))->date(),
                Tables\Columns\TextColumn::make('trip_time')->label(__('Trip Time'))->time(),
                Tables\Columns\TextColumn::make('people_count')->label(__('People Count')),

                Tables\Columns\BadgeColumn::make('car_type')
                    ->label('Car Type')
                    ->formatStateUsing(fn($state) => CarTypeEnum::from($state)->label())
                    ->colors([
                        'success' => fn($state) => $state === CarTypeEnum::PrivateCar->value,
                        'warning' => fn($state) => $state === CarTypeEnum::MiniBus->value,
                        'danger'  => fn($state) => $state === CarTypeEnum::BigBus->value,
                    ]),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime('d M, Y H:i:s')
                    ->sortable()
                    ->tooltip(fn($record) => $record->created_at?->format('Y-m-d H:i:s') ?? __('No Date')),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('car_type')
                    ->options(
                        collect(CarTypeEnum::cases())
                            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
                    ),
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
            'index' => Pages\ListTransportBookings::route('/'),
            'create' => Pages\CreateTransportBooking::route('/create'),
            'edit' => Pages\EditTransportBooking::route('/{record}/edit'),
        ];
    }
}
