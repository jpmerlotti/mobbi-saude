<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.simple', ['title' => 'Registre-se'])]
class Register extends Component implements HasForms
{
    use InteractsWithForms;

    public array $data;

    public function mount(): void
    {
        $this->data = [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => ''
        ];
    }

    public function register()
    {
        $data = $this->form->getState();

        $user = User::create($data);

        Auth::login($user);

        return redirect(route('home'))->intended();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome Completo')
                    ->required()
                    ->string()
                    ->minLength(3)
                    ->maxLength(100),
                TextInput::make('email')
                    ->label('E-mail')
                    ->required()
                    ->string()
                    ->email()
                    ->unique(table: User::class, column: 'email'),
                TextInput::make('password')
                    ->label('Senha')
                    ->password()
                    ->required()
                    ->rule(
                        Password::default()
                            ->mixedCase()
                            ->numbers()
                            ->symbols()
                    )
                    ->same('password_confirmation')
                    ->revealable(),
                TextInput::make('password_confirmation')
                    ->label('Confirme sua Senha')
                    ->password()
                    ->required()
                    ->revealable(),
            ])
            ->statePath('data');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
