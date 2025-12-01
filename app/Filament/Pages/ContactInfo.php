<?php

namespace App\Filament\Pages;

use App\Models\ContactInfo as ModelsContactInfo;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Pages\Page;
use Filament\Forms\Form;
use Filament\Forms\Components\RichEditor;
use Filament\Notifications\Notification;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class ContactInfo extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    protected static string $view = 'filament.pages.contact-info-settings';
    protected static ?string $navigationLabel = 'Contact Info';

    public ?ModelsContactInfo $contact;
    public array $data = [];

    public function mount(): void
    {
        $this->contact = ModelsContactInfo::firstOrCreate([]);

        // Prefill form
        $this->data = $this->contact->toArray();

        $this->form->fill($this->data);
    }

    public function getTitle(): string
    {
        return __('Contact Info');
    }

    public static function getNavigationLabel(): string
    {
        return __('Contact Info');
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([


                Forms\Components\Grid::make(2)
                    ->schema([

                        Forms\Components\TextInput::make('title')
                            ->label(__('Title'))
                            ->required(),
                        Forms\Components\TextInput::make('map_link')
                            ->label(__('Map Link'))
                            ->required(),

                        // FileUpload::make('map_image')
                        //     ->label(__('Map Image'))
                        //     ->image()
                        //     ->directory('contact-info')
                        //     ->disk('public')
                        //     ->visibility('public')
                        //     ->required()
                        //     ->imagePreviewHeight('100'),

                        // RichEditor::make('description')
                        //     ->label(__('Description'))
                        //     ->required(),
                    ]),

                Forms\Components\Grid::make(2)
                    ->schema([

                        Forms\Components\TextInput::make('email')
                            ->label(__('Email'))->required(),
                        Forms\Components\Textarea::make('address')->required()
                            ->label(__('Address')),
                    ]),


                Forms\Components\Grid::make(2)
                    ->schema([

                        Forms\Components\TextInput::make('phone1')
                            ->label(__('Phone 1'))->required(),

                        Forms\Components\TextInput::make('phone2')->required()
                            ->label(__('Phone 2')),
                    ]),
                Forms\Components\Grid::make(2)
                    ->schema([

                        Forms\Components\TextInput::make('whatsapp_number')->required()
                            ->label(__('Whatsapp Number')),
                        Forms\Components\TextInput::make('facebook_link')
                            ->label(__('Facebook Link')),
                        Forms\Components\TextInput::make('instagram_link')
                            ->label(__('Instagram Link')),
                        Forms\Components\TextInput::make('linkedin_link')
                            ->label(__('Linkedin Link')),


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
            $rules = Validator::make($this->data, [
                'title'       => ['required'],
                // 'description' => ['required'],
                'email'       => ['required', 'email'],
               // 'map_image'   =>  ['required','string'],
                'phone1'      => ['required'],
                'phone2'      => ['required'],
                'address'     => ['required'],
                'map_link'    => ['required'],
                'facebook_link' => ['nullable'],
                'instagram_link' => ['nullable'],
                'linkedin_link' => ['nullable'],
                'whatsapp_number' => ['required'],

            ])->validate();

            $validated = $this->form->getState();

            $validated = validator($validated, $rules)->validate();

            // Convert image array -> string (لو رجعت Array)
            // if (is_array($validated['image'])) {
            //     $validated['image'] = collect($validated['image'])->first();
            // }

            $this->contact->update($validated);
            $this->contact->refresh();

            Notification::make()
                ->title(__('Saved successfully'))
                ->success()
                ->body(__('Contact Info updated successfully!'))
                ->send();
        } catch (\Throwable $th) {
            dd($th);
            Notification::make()
                ->title(__("We can't save the data, please contact the administrator"))
                ->danger()
                ->send();

            throw ValidationException::withMessages([
                'errors' => [$th->getMessage()],
            ]);
        }
    }
}
