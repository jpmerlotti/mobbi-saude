<?php

namespace App\Filament\Clusters\Profile\Pages;

use App\Filament\Clusters\Profile;
use App\Models\User;
use App\Services\Auth\UserService;
use Closure;
use Exception;
use Filament\Facades\Filament;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EditUserPassword extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';

    protected static ?string $navigationLabel = 'Trocar Senha';

    protected static ?int $navigationSort = 3;

    protected static ?string $slug = 'me/password';

    protected ?string $heading = '';

    protected ?string $subheading = '';

    protected static string $view = 'filament.clusters.profile.pages.edit-user-password';

    protected static ?string $cluster = Profile::class;

    public function getTitle(): string|Htmlable
    {
        return self::$navigationLabel;
    }

    public ?array $data = [
        'old_password' => null,
        'new_password' => null,
        'new_password_confirmation' => null,
    ];

    public User $user;

    public function mount(): void
    {
        $this->user = auth()->user();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Trocar Senha')
                    ->description('Você pode trocar sua senha aqui.')
                    ->icon('heroicon-o-pencil-square')
                    ->schema([
                        TextInput::make('old_password')
                            ->label('Senha Atual')
                            ->password()
                            ->revealable()
                            ->placeholder('Digite a senha atual para confirmar a troca.')
                            ->required()
                            ->rules([
                                fn(): Closure => function (string $attribute, $value, Closure $fail) {
                                    if (! password_verify($value, auth()->user()->password)) {
                                        $fail('A senha digitada e a senha atual não correspondem');
                                    }
                                },
                            ]),
                        TextInput::make('new_password')
                            ->label('Nova Senha')
                            ->password()
                            ->revealable()
                            ->required()
                            ->dehydrated(fn($state): bool => filled($state))
                            ->dehydrateStateUsing(fn($state): string => Hash::make($state))
                            ->placeholder('')
                            ->live(debounce: 500)
                            ->autofocus()
                            ->rules([
                                Password::default()
                                    ->mixedCase()
                                    ->symbols()
                                    ->numbers(),
                                'confirmed:new_password_confirmation',
                                fn(): Closure => function (string $attribute, $value, Closure $fail) {
                                    if (password_verify($value, auth()->user()->password)) {
                                        $fail('A senha digitada não pode ser a mesma da senha atual');
                                    }
                                },
                            ])
                            ->validationMessages([
                                'required' => 'A senha é obrigatória',
                                'min' => 'A senha deve ter pelo menos 8 caracteres',
                                'same' => 'A senha deve ser igual à confirmação de senha',
                                'password.mixed' => 'A senha deve conter letras maiúsculas e minúsculas',
                                'password.symbols' => 'A senha deve conter símbolos',
                                'password.numbers' => 'A senha deve conter números',
                                'password.letters' => 'A senha deve conter letras',
                            ]),
                        TextInput::make('new_password_confirmation')
                            ->label('Confirmar Nova Senha')
                            ->password()
                            ->revealable()
                            ->required()
                            ->placeholder('Confirme a nova senha')
                            ->dehydrated(false),
                    ]),
            ])
            ->statePath('data');
    }

    public function handle(): void
    {
        try {
            $data = $this->form->getState(); //@phpstan-ignore-line

            $service = new UserService;

            $service->updatePassword($this->user, $data);
        } catch (Exception $exception) {
            Notification::make()
                ->danger()
                ->title($exception->getMessage())
                ->send();

            return;
        }

        if (request()->hasSession() && array_key_exists('new_password', $data)) {
            request()->session()->put(['password_hash_' . Filament::getAuthGuard() => $data['new_password']]);
        }

        $this->form->fill(); //@phpstan-ignore-line

        Notification::make()
            ->success()
            ->title('Senha alterada com sucesso')
            ->send();
    }
}
