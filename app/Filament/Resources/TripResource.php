<?php

namespace App\Filament\Resources;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Filament\Resources\TripResource\Pages;
use App\Filament\Resources\TripResource\RelationManagers;
use App\Models\Trip;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use PhpOffice\PhpSpreadsheet\RichText\RichText;

use function Laravel\Prompts\textarea;

class TripResource extends Resource
{
    protected static ?string $model = Trip::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getNavigationGroup(): ?string
    {
        return __('Trips');
    }

    public static function getNavigationLabel(): string
    {
        return __('Trips');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Trips');
    }

    public static function getModelLabel(): string
    {
        return __('Trip');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('Title'))
                    ->maxLength(255),
                // Forms\Components\Grid::make(2)
                //     ->schema([

                //     Forms\Components\Select::make('category_id')
                //         ->label('التصنيف')
                //         ->relationship('category', 'title')
                //         ->required()
                //         ->reactive() // يخلي الفيلد يتفاعل مع التغيير

                //     ,

                //     Forms\Components\Select::make('sub_category_id')
                //         ->label('التصنيف الفرعي')
                //         ->options(function (callable $get) {
                //             $categoryId = $get('category_id');
                //             if (!$categoryId) {
                //                 return [];
                //             }

                //             return \App\Models\SubCategory::where('category_id', $categoryId)
                //                 ->pluck('title', 'id');
                //         })
                //         ->reactive()
                //         ->disabled(fn(callable $get) => !$get('category_id')),
                // ]),



                // Forms\Components\TextInput::make('destination')
                //     ->label('الوجهة')
                //     ->required(),

                Forms\Components\TextInput::make('duration')
                    ->label(__('Duration'))
                    ->required(),


                Forms\Components\Grid::make(2)
                    ->schema([

                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->label(__('Price'))
                            ->required(),

                        Forms\Components\TextInput::make('currency')
                            ->label(__('Currency'))
                            ->required()
                            ->default('EGP'),
                    ]),
                Forms\Components\Grid::make(1)
                    ->schema([
                        TinyEditor::make('overview')
                            ->label(__('Overview'))
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsDirectory('uploads')
                            ->profile('default|simple|full|minimal|none|custom')
                            ->direction('auto|rtl|ltr')
                            ->columnSpan('full')
                            ->required(),
                        TinyEditor::make('highlights')
                            ->label(__('Highlights'))
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsDirectory('uploads')
                            ->profile('default|simple|full|minimal|none|custom')
                            ->direction('auto|rtl|ltr')
                            ->columnSpan('full')
                            ->required(),
                        TinyEditor::make('itinerary')
                            ->label(__('Itinerary'))
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsDirectory('uploads')
                            ->profile('default|simple|full|minimal|none|custom')
                            ->direction('auto|rtl|ltr')
                            ->columnSpan('full')
                            ->required(),
                        TinyEditor::make('accommodation')
                            ->label(__('Accommodation'))
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsDirectory('uploads')
                            ->profile('default|simple|full|minimal|none|custom')
                            ->direction('auto|rtl|ltr')
                            ->columnSpan('full')
                            ->required(),
                        TinyEditor::make('inclusions')
                            ->label(__('Inclusions'))
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsDirectory('uploads')
                            ->profile('default|simple|full|minimal|none|custom')
                            ->direction('auto|rtl|ltr')
                            ->columnSpan('full')
                            ->required(),
                    ]),

                Forms\Components\TextInput::make('map_link')
                    ->required()
                    ->label(__('Map Link')),
                Forms\Components\Grid::make(2) // 2 يعني عمودين
                    ->schema([
                        Forms\Components\Toggle::make('is_best_seller')
                            ->label(__('Is Best Seller'))
                            ->default(false),

                        Forms\Components\Toggle::make('is_popular')
                            ->label(__('Is Popular'))
                            ->default(false),
                    ]),

                // Forms\Components\TextInput::make('rating')
                //     ->numeric()
                //     ->label('التقييم')
                //     ->required()
                //     ->default(0),

                Textarea::make('meta_title')
                    ->required()
                    ->label(__('Meta Title')),
                textarea::make('meta_description')
                    ->required()
                    ->label(__('Meta Description')),
                Forms\Components\Grid::make(1)
                    ->schema([

                        FileUpload::make('cover_image')
                            ->label(__('Cover Image'))
                            ->image()
                            ->directory('trips')
                            ->disk('public')
                            ->visibility('public')
                            ->required()
                            ->imagePreviewHeight('100'),
                    ]),

                Forms\Components\Grid::make(1)
                    ->schema([

                        FileUpload::make('images')
                            ->label(__('Images'))
                            ->multiple()
                            ->image()
                            ->directory('trips')
                            ->disk('public')
                            ->visibility('public')
                            ->required()
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
                ImageColumn::make('cover_image')->label(__('Cover Image'))->circular()->width(50)->height(50),
                Tables\Columns\TextColumn::make('title')->label('العنوان')->searchable(),
                // Tables\Columns\TextColumn::make('category.title')->label('التصنيف'),
                // Tables\Columns\TextColumn::make('subCategory.title')->label('التصنيف الفرعي'),
                // Tables\Columns\TextColumn::make('destination')->label('الوجهة'),
                Tables\Columns\TextColumn::make('duration')->label('المدة'),
                Tables\Columns\TextColumn::make('price')->label('السعر'),
                Tables\Columns\TextColumn::make('currency')->label('العملة'),
                // Tables\Columns\ImageColumn::make('images')->label('الصورة'),
                Tables\Columns\IconColumn::make('is_popular')
                    ->boolean()
                    ->label('شائع'),

                Tables\Columns\IconColumn::make('is_best_seller')
                    ->boolean()
                    ->label('أفضل بيع'),
                // Tables\Columns\TextColumn::make('rating')->label('التقييم'),
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
            'index' => Pages\ListTrips::route('/'),
            'create' => Pages\CreateTrip::route('/create'),
            'edit' => Pages\EditTrip::route('/{record}/edit'),
        ];
    }
}
