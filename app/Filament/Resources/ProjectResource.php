<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;
    public static function getNavigationGroup(): ?string
    {
        return __('Projects');
    }

    public static function getNavigationLabel(): string
    {
        return __('Projects');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Projects');
    }

    public static function getModelLabel(): string
    {
        return __('Project');
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->label(__('Title'))
                    ->required()
                    ->maxLength(255),

                Textarea::make('short_description')
                    ->required()
                    ->label(__('Short Description')),

                TinyEditor::make('description')
                    ->label(__('Description'))
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsVisibility('public')
                    ->fileAttachmentsDirectory('uploads')
                    ->profile('default|simple|full|minimal|none|custom')
                    ->direction('auto|rtl|ltr')
                    ->columnSpan('full')
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'title')
                    ->label(__('Category'))
                    ->searchable()
                    ->required()
                    ->preload(),
                Forms\Components\Select::make('status_id')
                    ->relationship('status', 'title')
                    ->label(__('Status'))
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('scope_id')
                    ->relationship('scope', 'title')
                    ->label(__('Scope'))
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('year_id')
                    ->relationship('year', 'title')
                    ->label(__('Year'))
                    ->searchable()
                    ->preload(),

                // Forms\Components\Select::make('scale_id')
                //     ->relationship('scale', 'title')
                //     ->label(__('Scale'))
                //     ->searchable()
                //     ->preload(),

                Forms\Components\TextInput::make('owner')->label(__('Owner'))->maxLength(255),
                Forms\Components\TextInput::make('location')->label(__('Location'))->maxLength(255),
                Forms\Components\TextInput::make('map_link')->label(__('Map Link'))->maxLength(255),


                FileUpload::make('cover_image')
                    ->label(__('Cover Image'))
                    ->image()
                    ->directory('projects')
                    ->disk('public')
                    ->visibility('public')
                    ->required()
                    ->imagePreviewHeight('100'),

                FileUpload::make('images')
                    ->label(__('Images'))
                    ->multiple()
                    ->image()
                    ->directory('projects')
                    ->disk('public')
                    ->visibility('public')
                    ->required()
                    ->imagePreviewHeight('100'),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->label(__('Sort Order'))
                    ->default(0),
                // Forms\Components\Toggle::make('is_active')->label('Active'),

                Forms\Components\Section::make(__('SEO'))
                    ->schema([
                        Forms\Components\Textarea::make('meta_title')->label(__('Meta Title')),
                        //     Forms\Components\Textarea::make('meta_keywords')->label(__('Meta Keywords')),
                        Forms\Components\Textarea::make('meta_description')->label(__('Meta Description')),
                    ])
                    ->collapsible(),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')->label(__('Cover Image'))->circular()->width(50)->height(50),
                Tables\Columns\TextColumn::make('title')->label(__('Title'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('category.title')->label(__('Category'))->sortable(),
                Tables\Columns\TextColumn::make('status.title')->label(__('Status'))->sortable(),
                Tables\Columns\TextColumn::make('scope.title')->label(__('Scope'))->sortable(),
               // Tables\Columns\TextColumn::make('scale.title')->label(__('Scale'))->sortable(),
                Tables\Columns\TextColumn::make('year.title')->label(__('Year'))->sortable(),
                ToggleColumn::make('is_active')
                    ->label(__('Is Active?'))
                    ->onColor('success')
                    ->offColor('gray')
                    ->onIcon('heroicon-m-check')
                    ->offIcon('heroicon-m-x-mark')
                    ->getStateUsing(fn($record) => $record->is_active)
                    ->afterStateUpdated(fn($record, $state) => $record->update(['is_active' => $state])),

                Tables\Columns\TextColumn::make('sort_order')->label(__('Sort Order'))->sortable(),
                TextColumn::make('created_at')
                    ->label(__('Created At'))
                    ->dateTime('d M, Y H:i:s')
                    ->sortable()
                    ->tooltip(fn($record) => $record->created_at?->format('Y-m-d H:i:s') ?? __('No Date')),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
