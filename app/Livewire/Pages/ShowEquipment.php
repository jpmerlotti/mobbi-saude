<?php

namespace App\Livewire\Pages;

use App\Livewire\Forms\PersonForm;
use App\Models\Equipment;
use App\Models\Rental;
use Carbon\Carbon;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Schema;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Show Equipment'])]
class ShowEquipment extends Component implements HasForms
{
    use InteractsWithForms;

    #[Url()]
    public Equipment $equipment;

    public array $data = [];

    public bool $showModal = false;

    public function mount(): void
    {
        $this->equipment->load([
            'owner',
            'images',
            'equipmentType',
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Período')
                        ->description('Informe para o proprietário o período pelo qual você precisará do equipamento para avaliação.')
                        ->schema([
                            DatePicker::make('start')
                                ->live(true)
                                ->required()
                                ->minDate(now()->format('Y-m-d'))
                                ->maxDate(now()->addYear())
                                ->label('Início'),
                            DatePicker::make('end')
                                ->minDate(fn (Get $get) => Carbon::make($get('start'))?->addDay())
                                ->maxDate(fn (Get $get) => Carbon::make($get('start'))?->addDecade())
                                ->label('Fim')
                                ->helperText('Deixe esse campo vazio caso não haja previsão de devolução no momento. (Isso pode diminuir as chances de ser aprovado.)'),

                        ])->columns([
                            'xs' => 1,
                            'md' => 2,
                        ]),
                    Step::make('Contato')
                        ->description('Informe seus dados de contato para que o dono do equipamento possa procurá-lo.')
                        ->schema([
                            TextInput::make('contact_name')
                                ->label('Nome')
                                ->required()
                                ->columnSpanFull(),
                            TextInput::make('contact_email')
                                ->label('Email')
                                ->live()
                                ->placeholder('seuemail@example.com')
                                ->required(fn (Get $get): bool => empty($get('contact_phone'))),
                            TextInput::make('contact_phone')
                                ->label('Telefone')
                                ->mask('(99) 9 9999-9999')
                                ->live()
                                ->placeholder('(99) 9 9999-9999')
                                ->required(fn (Get $get): bool => empty($get('contact_email'))),
                            TextInput::make('contact_type')
                                ->label('Tipo de Contato')
                                ->helperText('Ex: Mensagem via WhatsApp/Email ou Ligação')
                                ->required()
                                ->columnSpanFull(),
                            Textarea::make('contact_message')
                                ->label('Mensagem')
                                ->helperText('Utilize o campo acima para deixar uma mensagem opcional para o proprietário.')
                                ->columnSpanFull(),
                            Checkbox::make('contact_agree')
                                ->label('Eu permito que o proprietário do equipamento use os dados acima informados para entrar em contato comigo.')
                                ->required()
                                ->columnSpanFull(),
                        ])->columns(2)
                ])->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-forms.button type="submit" wire:loading.attr="disabled">
                        Solicitar
                    </x-forms.button>
            BLADE))),
            ])
            ->statePath('data');
    }

    protected function handleSave(array $data): void
    {
        $data['equipment_id'] = $this->equipment->id;
        $data['borrower_id'] = Auth::id();

        try {
            Rental::create($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function save(): void
    {
        $data = $this->form->getState();

        try {
            $this->handleSave($data);
        } catch (\Exception $e) {
            $this->redirect(route('show-equipment', ['equipment' => $this->equipment]),
                 true);

            Notification::make()
                ->danger()
                ->title('Erro ao criar solicitação de aluguel.')
                ->body($e->getMessage())
                // ->body('Houve um erro ao solicitar esse equipamento, tente novamente em alguns instantes.')
                ->send();

            return;
        }

        $this->redirect(route('home'), true);

        Notification::make()
            ->success()
            ->title('Solicitação de aluguel registrada.')
            ->body('Foi enviada uma solicitação ao dono do equipamento, em breve você receberá uma resposta pelo meio de contato fornecido.')
            ->send();

        return;
    }

    public function rentalForm(): void
    {
        $this->showModal = true;
        $this->form->fill();
    }

    public function render()
    {
        return view('livewire.pages.show-equipment');
    }
}
