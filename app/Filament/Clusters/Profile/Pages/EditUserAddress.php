<?php

namespace App\Filament\Clusters\Profile\Pages;

use App\Enums\BrazilStatesEnum;
use App\Filament\Clusters\Profile;
use App\Models\Address;
use App\Models\User;
use App\Services\Address\AddressService;
use Exception;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;
use Illuminate\Contracts\Support\Htmlable;
use Leandrocfe\FilamentPtbrFormFields\Cep;

class EditUserAddress extends Page implements HasForms
{
    use InteractsWithForms;
    //

    protected static ?string $cluster = Profile::class;
    protected static ?string $navigationLabel = 'Atualizar Endereço';
    protected ?string $heading = '';
    protected static ?string $title = 'Atualizar Endereço';
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?int $navigationSort = 2;
    protected static ?string $slug = 'me/address';
    protected static string $view = 'filament.clusters.profile.pages.edit-user-address';

    public array $data = [
        'city' => '',
        'street' => '',
        'district' => '',
        'state' => '',
        'number' => '',
        'complement' => '',
        'cep' => ''
    ];
    protected User $user;
    protected ?Address $address;

    public function getTitle(): string|Htmlable
    {
        return self::$navigationLabel;
    }

    public function mount(): void
    {
        $this->user = auth()->user();

        $this->address = $this->user->address;

        if ($this->address != null) {
            $this->data = [
                'city' => $this->address->city,
                'street' => $this->address->street,
                'district' => $this->address->district,
                'state' => $this->address->state,
                'number' => $this->address->number,
                'complement' => $this->address->complement,
                'cep' => $this->address->cep
            ];
        }
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Seu Endereço')
                ->description('Você pode atualizar seu endereço.')
                ->icon('heroicon-o-pencil-square')
                ->schema([
                    Cep::make('cep')
                        ->label('CEP')
                        ->viaCep(
                            mode: 'prefix',
                            errorMessage: 'CEP inválido!',
                            setFields: [
                                'street' => 'logradouro',
                                'number' => 'numero',
                                'complement' => 'complemento',
                                'district' => 'bairro',
                                'city' => 'localidade',
                                'state' => 'uf'
                            ]
                        )
                        ->required()
                        ->columnSpan(2),
                    TextInput::make('street')
                        ->label('Rua')
                        ->required()
                        ->columnSpan(2),
                    TextInput::make('number')
                        ->numeric()
                        ->label('Número')
                        ->required()
                        ->columnSpan(1),
                    TextInput::make('district')
                        ->label('Bairro')
                        ->required()
                        ->columnSpan(1),
                    TextInput::make('complement')
                        ->label('Complemento')
                        ->columnSpan(2),
                    TextInput::make('city')
                        ->label('Cidade')
                        ->required()
                        ->columnSpan(1),
                    Select::make('state')
                        ->label('Estado')
                        ->options(BrazilStatesEnum::toArray())
                        ->placeholder('Selecione seu estado')
                        ->required()
                        ->columnSpan(1)
                ])->columns(2),
        ])->statePath('data');
    }

    public function handle(): void
    {
        $data = $this->form->getState();

        $service = app(AddressService::class);

        try {
            if ($service->save($data)) {
                Notification::make()
                    ->success()
                    ->title('Endereço salvo com sucesso.')
                    ->send();
            } else {
                Notification::make()
                    ->danger()
                    ->title('Erro ao salvar endereço')
                    ->send();
            }
        } catch (Exception $e) {
            Notification::make()
                ->danger()
                ->title('Erro ao salvar endereço')
                ->send();

            throw new Halt;
        }
    }
}
