<?php

namespace App\Filament\Resources;

use App\Enums\ClassTypeEnum;
use App\Enums\TicketTypeEnum;
use App\Filament\Resources\FlightBookingResource\Pages;
use App\Filament\Resources\FlightBookingResource\RelationManagers;
use App\Models\FlightBooking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FlightBookingResource extends Resource
{
    protected static ?string $model = FlightBooking::class;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationGroup(): ?string
    {
        return __('Requests');
    }
    public static function getNavigationLabel(): string
    {
        return __('Fight Booking Requests');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Fight Booking Requests');
    }

    public static function getModelLabel(): string
    {
        return __('Fight Booking Requests');
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
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')->label('البريد الإلكتروني'),
                Tables\Columns\TextColumn::make('phone')->label('الهاتف'),

                Tables\Columns\BadgeColumn::make('ticket_type')
                    ->formatStateUsing(fn(?TicketTypeEnum $state) => $state?->label())
                    ->colors(fn(?TicketTypeEnum $state) => [
                        'success' => $state === TicketTypeEnum::ONE_WAY,
                        'warning' => $state === TicketTypeEnum::ROUND_TRIP,
                        'secondary' => !in_array($state, [TicketTypeEnum::ONE_WAY, TicketTypeEnum::ROUND_TRIP]),
                    ]),
                Tables\Columns\BadgeColumn::make('class_type')
                    ->label('درجة الحجز')
                    ->formatStateUsing(fn(?ClassTypeEnum $state) => $state?->label())
                    ->colors(fn(?ClassTypeEnum $state) => [
                        'success' => $state === ClassTypeEnum::ECONOMY,
                        'warning' => $state === ClassTypeEnum::BUSINESS,
                        'secondary' => $state === ClassTypeEnum::FIRST,
                    ]),


                Tables\Columns\TextColumn::make('origin')->label('من'),
                Tables\Columns\TextColumn::make('destination')->label('إلى'),

                Tables\Columns\TextColumn::make('adults')->label('بالغ'),
                Tables\Columns\TextColumn::make('children')->label('طفل'),
                Tables\Columns\TextColumn::make('infants')->label('رضيع'),

                Tables\Columns\TextColumn::make('departure_date')->label('تاريخ السفر')->date(),
                Tables\Columns\TextColumn::make('return_date')->label('تاريخ العودة')->date(),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('ticket_type')
                    ->label('نوع التذكرة')
                    ->options(collect(TicketTypeEnum::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])),

                Tables\Filters\SelectFilter::make('class_type')
                    ->label('درجة الحجز')
                    ->options(collect(ClassTypeEnum::cases())->mapWithKeys(fn($case) => [$case->value => $case->label()])),
            ])

            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListFlightBookings::route('/'),
            'create' => Pages\CreateFlightBooking::route('/create'),
            'edit' => Pages\EditFlightBooking::route('/{record}/edit'),
        ];
    }
}
