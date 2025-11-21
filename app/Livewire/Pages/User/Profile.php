<?php

namespace App\Livewire\Pages\User;

use App\Models\User;
use App\Rules\CpfCnpj;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Exceptions\Halt;
use Filament\Support\Icons\Heroicon;
use Filament\Support\RawJs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Meu Perfil'])]
class Profile extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];


    #[Computed]
    public function user(): User
    {
        return Auth::user();
    }

    public function mount()
    {
        $this->form->fill($this->user->toArray());
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Profile')
                ->description('Mantenha seus dados de contato atualizados.')
                    ->icon(Heroicon::User)
                    ->aside()
                    ->schema([
                        FileUpload::make('avatar_path')
                            ->label('Avatar')
                            ->avatar()
                            ->image()
                            ->imageEditor()
                            ->circleCropper()
                            ->disk('s3')
                            ->directory(fn ($record): string => 'avatars/' . (string) $record->id),

                        TextInput::make('name')
                            ->label('Nome Completo')
                            ->required(),

                        TextInput::make('email')
                            ->label('Endereço de E-mail')
                            ->email()
                            ->required()
                            ->unique(),

                        TextInput::make('phone')
                            ->mask('(99) 9 9999-9999')
                            ->label('Telefone')
                            ->required(),

                        TextInput::make('document')
                            ->rule(new CpfCnpj)
                            ->mask(RawJs::make(<<<'JS'
                                $input.length <= 14 ? '999.999.999-99' : '99.999.999/9999-99'
                            JS))
                            ->label('Documento')
                            ->helperText('CPF ou CNPJ')
                            ->required(),

                        DatePicker::make('birth_date')
                            ->label('Data de Nascimento')
                            ->format('d/m/Y')
                            ->minDate(now()->subYears(100))
                            ->required(),
                    ]),
            Section::make('Address')
                ->description('Mantenha seu endereço atualizado.')
                ->icon(Heroicon::MapPin)
                ->aside()
                ->schema([
                    TextInput::make('address_zip_code')
                        ->default(Auth::user()->address_zip_code)
                        ->mask('99999-999')
                        ->live(true)
                        ->label('CEP')
                        ->required()
                        ->afterStateUpdated(function (Set $set, ?string $state) {
                            $cep = preg_replace('/[^0-9]/', '', $state);
                            if (strlen($cep) !== 8) {
                                return;
                            }

                            $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

                            if ($response->successful() && !isset($response->json()['erro'])) {
                                $data = $response->json();
                                $set('address_street', $data['logradouro']);
                                $set('address_district', $data['bairro']);
                                $set('address_city', $data['localidade']);
                                $set('address_state', $data['uf']);
                            }
                        }),
                    TextInput::make('address_street')
                        ->default(fn ($get) => $get('address_zip_code'))
                        ->label('Rua')
                        ->required(),
                    TextInput::make('address_number')
                        ->label('Número')
                        ->required(),
                    TextInput::make('address_complement')
                        ->label('Complemento'),
                    TextInput::make('address_district')
                        ->label('Bairro')
                        ->required(),
                    TextInput::make('address_city')
                        ->label('Cidade')
                        ->required(),
                    Select::make('address_state')
                        ->label('Estado')
                        ->options([
                            'AC' => 'Acre',
                            'AL' => 'Alagoas',
                            'AP' => 'Amapá',
                            'AM' => 'Amazonas',
                            'BA' => 'Bahia',
                            'CE' => 'Ceará',
                            'DF' => 'Distrito Federal',
                            'ES' => 'Espírito Santo',
                            'GO' => 'Goiás',
                            'MA' => 'Maranhão',
                            'MT' => 'Mato Grosso',
                            'MS' => 'Mato Grosso do Sul',
                            'MG' => 'Minas Gerais',
                            'PA' => 'Pará',
                            'PB' => 'Paraíba',
                            'PR' => 'Paraná',
                            'PE' => 'Pernambuco',
                            'PI' => 'Piauí',
                            'RJ' => 'Rio de Janeiro',
                            'RN' => 'Rio Grande do Norte',
                            'RS' => 'Rio Grande do Sul',
                            'RO' => 'Rondônia',
                            'RR' => 'Roraima',
                            'SC' => 'Santa Catarina',
                            'SP' => 'São Paulo',
                            'SE' => 'Sergipe',
                            'TO' => 'Tocantins',
                        ])
                        ->required(),
                ]),
            Section::make('Alterar Senha')
                ->description('Mantenha sua senha atualizada e segura.')
                ->icon(fn () => Heroicon::Key)
                ->aside()
                ->schema([
                    TextInput::make('current_password')
                        ->label('Senha Atual')
                        ->password()
                        ->revealable(),
                    TextInput::make('password')
                        ->label('Nova Senha')
                        ->password()
                        ->same('password_confirmation')
                        ->revealable()
                        ->confirmed(),
                    TextInput::make('password_confirmation')
                        ->label('Confirme a Nova Senha')
                        ->password()
                        ->revealable(),
                ]),
        ])
        ->model($this->user)
        ->statePath('data');
    }

    protected function handleSave(array $data): void
    {
        $user = $this->user;

        if (!empty($data['password'])) {
            Hash::check($data['current_password'], $user->password);

            $user->update([
                'password' => Hash::make($data['password']),
            ]);

        }

        unset(
            $data['current_password'],
            $data['password'],
            $data['password_confirmation']
        );

        try {
            $user->update($data);
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
            $this->redirect(route('profile'), true);

            Notification::make()
                ->danger()
                ->title('Erro ao salvar alterações.')
                ->body($e->getMessage())
                ->send();

            return;
        }

        Notification::make()
            ->success()
            ->title('Perfil atualizado com sucesso.')
            ->send();

        $this->redirect(route('profile'), navigate: true);
    }

    public function render()
    {
        return view('livewire.pages.user.profile');
    }
}
