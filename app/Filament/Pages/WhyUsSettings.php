<?php

namespace App\Filament\Pages;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Models\AboutUs;
use App\Models\WhyUs;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class WhyUsSettings extends Page implements HasForms
{
    use InteractsWithForms;
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static string $view = 'filament.pages.why-us-settings';
    protected static ?string $navigationLabel = 'Why Us';

    // protected static ?string $title = 'About Us Settings';
    public ?WhyUs $whyUs;
    public array $data = [];
    public function mount(): void
    {
        $this->whyUs = WhyUs::firstOrCreate([]); // ✅ assign it to the class property

        // Optional: prefill the form using the model data
        $this->data = [
            'title' => $this->whyUs->title,
            'description' => $this->whyUs->description,
        ];

        $this->form->fill($this->whyUs->toArray());
    }
    public function getTitle(): string
    {
        return __('Why Us');
    }
    public static function getNavigationLabel(): string
    {
        return __('Why Us');
    }



    public function form(Form $form): Form
    {
        return $form
            ->model($this->whyUs)
            ->statePath('data')
            ->schema([
                Forms\Components\Grid::make(1)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('Title'))
                            ->maxLength(255)
                            ->required(),
                    ]),

                Forms\Components\Grid::make(1)
                    ->schema([

                        TinyEditor::make('description')
                            ->label(__('Description'))
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsDirectory('uploads')
                            ->profile('default|simple|full|minimal|none|custom')
                            ->direction('auto|rtl|ltr')
                            ->columnSpan('full')
                            ->required(),
                    ]),
                // Forms\Components\Grid::make(1)
                //     ->schema([

                //         FileUpload::make('image')
                //             ->label(__('Image'))
                //             ->image()
                //             ->directory('about')
                //             ->disk('public')
                //             ->visibility('public')
                //             ->required()
                //             ->imagePreviewHeight('100'),

                //     ]),
            ]);
    }
    public static function canAccess(): bool
    {
        return Auth::user()?->hasRole('super_admin');
    }
    public function save(): void
    {
        try {
            $rules = [
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
            ];


            $validated = $this->form->getState();

            // // Convert image array -> string (لو رجعت Array)
            // if (is_array($validated['image'])) {
            //     $validated['image'] = collect($validated['image'])->first();
            // }


            $validated = validator($validated, $rules)->validate();

            $this->whyUs->update($validated);
            $this->whyUs->refresh();

            $this->form->fill($this->whyUs->toArray());

            Notification::make()
                ->title(__('Saved successfully'))
                ->success()
                ->body(__('Why Us updated successfully!'))
                ->send();

            redirect()->back();
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
