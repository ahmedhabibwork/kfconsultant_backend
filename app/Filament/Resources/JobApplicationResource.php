<?php

namespace App\Filament\Resources;

use Filament\Tables\Actions\Action;
use App\Filament\Resources\JobApplicationResource\Pages;
use App\Filament\Resources\JobApplicationResource\RelationManagers;
use App\Models\JobApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobApplicationResource extends Resource
{
    protected static ?string $model = JobApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationGroup(): ?string
    {
        return __('Requests');
    }
    public static function getNavigationLabel(): string
    {
        return __('Jop Applications');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Jop Applications');
    }

    public static function getModelLabel(): string
    {
        return __('Jop Applications');
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
                TextColumn::make('id')
                    ->sortable()
                    ->label(__('ID')),
                TextColumn::make('name')->label(__('name'))->sortable()->searchable(),
                TextColumn::make('phone')->label(__('Phone'))->sortable()->searchable(),
                TextColumn::make('email')->label(__('Email'))->sortable()->searchable(),

                ImageColumn::make('image')->label(__('Image'))
                    ->url(fn($record) => asset('storage/' . $record->image))
                    ->circular()->width(50)->height(50),
                TextColumn::make('job_title')
                    ->label(__('Job Title'))
                    ->sortable()
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime('d M, Y H:i:s')
                    ->sortable()
                    ->tooltip(fn($record) => $record->created_at?->format('Y-m-d H:i:s') ?? __('No Date')),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                // Tables\Filters\SelectFilter::make('job_title')
                //     ->label(__('Job Title'))
                //     ->options(
                //         collect(\App\Enums\JobTitleEnum::cases())
                //             ->mapWithKeys(fn($case) => [$case->value => $case->label()])
                //             ->toArray()
                //     ),
            ])
            ->actions([
                //   Tables\Actions\EditAction::make(),
                Action::make('download')
                    ->label(__('Download'))
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn($record) => asset('storage/' . $record->image))
                    ->openUrlInNewTab(),
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
            'index' => Pages\ListJobApplications::route('/'),
            'create' => Pages\CreateJobApplication::route('/create'),
            'edit' => Pages\EditJobApplication::route('/{record}/edit'),
        ];
    }
}
