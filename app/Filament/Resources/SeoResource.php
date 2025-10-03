<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Enums\PagesEnum;
use App\Filament\Resources\SeoResource\Pages;
use App\Filament\Resources\SeoResource\RelationManagers;
use App\Models\Seo;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SeoResource extends Resource
{
    protected static ?string $model = Seo::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function getNavigationLabel(): string
    {
        return __('Seos');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Seos');
    }

    public static function getModelLabel(): string
    {
        return __('Seo');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('page_name')
                    ->label(__('Page Name'))
                    ->options(
                        collect(PagesEnum::cases())
                            ->mapWithKeys(fn($case) => [$case->value => $case->label()])
                            ->toArray()
                    )
                    ->disabled()
                    ->required(),
                Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('Meta Title'))
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->label(__('Meta Description'))
                            ->required(),
                    ]),

                Grid::make(2)
                    ->schema([
                        Forms\Components\Textarea::make('og_description')
                            ->label(__('Open Graph Description')),
                        Forms\Components\Textarea::make('twitter_description')
                            ->label(__('Twitter Description')),
                    ]),


                Grid::make(2)
                    ->schema([

                        FileUpload::make('og_image')
                            ->label(__('Open Graph Image'))
                            ->image()
                            ->directory('seos')
                            ->disk('public')
                            ->visibility('public')

                            ->imagePreviewHeight('100'),

                        FileUpload::make('twitter_image')
                            ->label(__('Twitter Image'))
                            ->image()
                            ->directory('seos')
                            ->disk('public')
                            ->visibility('public')

                            ->imagePreviewHeight('100'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label(__('ID')),
                TextColumn::make('title')->label(__('Title'))->sortable()->searchable(),
                TextColumn::make(name: 'page_name')->label(__('Page Name'))->sortable()->searchable(),

                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime('d M, Y H:i:s')
                    ->sortable()
                    ->tooltip(fn($record) => $record->created_at?->format('Y-m-d H:i:s') ?? __('No Date')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                //   Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //      Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSeos::route('/'),
            'create' => Pages\CreateSeo::route('/create'),
            'edit' => Pages\EditSeo::route('/{record}/edit'),
        ];
    }
}
