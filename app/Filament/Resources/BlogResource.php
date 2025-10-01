<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Filament\Resources\BlogResource\Pages;
use App\Filament\Resources\BlogResource\RelationManagers;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationLabel(): string
    {
        return __('Blogs');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Blogs');
    }

    public static function getModelLabel(): string
    {
        return __('Blog');
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->label(__('Title')),
                TextInput::make('slug')
                    ->label(__('Slug')),

                DateTimePicker::make('published_date')
                    ->label(__('Published Date'))
                    ->native(false),


                FileUpload::make('images')
                    ->label(__('Image'))
                    ->multiple()
                    ->image()
                    ->directory('blogs')
                    ->disk('public')
                    ->visibility('public')
                    ->required()
                    ->imagePreviewHeight('100'),


                TinyEditor::make('description')
                    ->label(__('Description'))
                    ->fileAttachmentsDisk('public')
                    ->fileAttachmentsVisibility('public')
                    ->fileAttachmentsDirectory('uploads')
                    ->profile('default|simple|full|minimal|none|custom')
                    ->direction('auto|rtl|ltr')
                    ->columnSpan('full')
                    ->required(),
                Textarea::make('meta_title')
                    ->required()
                    ->label(__('Meta Title')),
                Textarea::make('meta_description')
                    ->required()
                    ->label(__('Meta Description')),

                Grid::make(2)
                    ->schema([
                        Toggle::make('is_published')->label(__('Is Published?'))->default(true),

                    ])


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
                TextColumn::make('slug')->label(__('Slug'))->sortable()->searchable(),

                ToggleColumn::make('is_published')
                    ->label(__('Is Published?'))
                    ->onColor('success')
                    ->offColor('gray')
                    ->onIcon('heroicon-m-check')
                    ->offIcon('heroicon-m-x-mark')
                    ->getStateUsing(fn($record) => $record->is_published)
                    ->afterStateUpdated(fn($record, $state) => $record->update(['is_published' => $state])),


                TextColumn::make('published_date')
                    ->label(__('Published Date'))
                    ->dateTime('d M, Y H:i:s')
                    ->sortable()
                    ->tooltip(fn($record) => $record->created_at?->format('Y-m-d H:i:s') ?? __('No Date')),
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
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
