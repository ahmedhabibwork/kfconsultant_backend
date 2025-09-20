<?php

namespace App\Filament\Pages;

use AmidEsfahani\FilamentTinyEditor\TinyEditor;
use App\Models\AboutUs;
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

class AboutUsSettings extends Page implements HasForms
{
    use InteractsWithForms;
    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static string $view = 'filament.pages.about-us-settings';
    protected static ?string $navigationLabel = 'About Us';
    protected static bool $shouldRegisterNavigation = false;

    // protected static ?string $title = 'About Us Settings';
    public ?AboutUs $about;
    public array $data = [];
    public function mount(): void
    {
        $this->about = AboutUs::firstOrCreate([]); // ✅ assign it to the class property

        // Optional: prefill the form using the model data
        $this->data = [
            'title' => $this->about->title,
            'description' => $this->about->description,
            'short_description' => $this->about->short_description,
            'experience_years' => $this->about->experience_years,
        ];

        $this->form->fill($this->about->toArray());
    }
    public function getTitle(): string
    {
        return __('About Us');
    }
    public static function getNavigationLabel(): string
    {
        return __('About Us');
    }



    public function form(Form $form): Form
    {
        return $form
            ->model($this->about)
            ->statePath('data')
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label(__('Title'))
                            ->maxLength(255)
                            ->required(),
                        Forms\Components\TextInput::make('experience_years')
                            ->label(__('Experience Years'))
                            ->minValue(1)
                            ->required(),
                        Textarea::make('short_description')
                            ->label(__('Short Description'))
                            ->maxLength(500)
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
                Forms\Components\Grid::make(1)
                    ->schema([

                        FileUpload::make('image')
                            ->label(__('Image'))
                            ->image()
                            ->directory('about')
                            ->disk('public')
                            ->visibility('public')
                            ->required()
                            ->imagePreviewHeight('100'),

                    ]),
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
                'short_description' => ['required', 'string', 'max:500'],
                'description' => ['required', 'string'],
                'experience_years' => ['required', 'integer'],
            ];

            // ✅ خد البيانات من الفورم
            $validated = $this->form->getState();

            // Convert image array -> string (لو رجعت Array)
            if (is_array($validated['image'])) {
                $validated['image'] = collect($validated['image'])->first();
            }

            // ✅ اعمل validate يدوي قبل الحفظ
            $validated = validator($validated, $rules)->validate();

            $this->about->update($validated);
            $this->about->refresh();

            $this->form->fill($this->about->toArray());

            Notification::make()
                ->title(__('Saved successfully'))
                ->success()
                ->body(__('About Us updated successfully!'))
                ->send();

            redirect()->back();
        } catch (\Throwable $th) {
            dd($th);
        }
    }
}
