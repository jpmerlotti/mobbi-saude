<?php

namespace App\Livewire\Auth;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.simple', ['title' => 'Entrar'])]
class Login extends Component implements HasForms
{
    use InteractsWithForms;

    public array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'email' => '',
            'password' => '',
            'remember_me' => false,
        ]);
    }

    // ASSINATURA CORRETA (v4)
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('email')
                    ->label('E-mail')
                    ->required()
                    ->email(),
                TextInput::make('password')
                    ->label('Senha')
                    ->password()
                    ->required()
                    ->revealable(),
                Checkbox::make('remember_me')
                    ->label('Lembrar de mim'),
            ])
            ->statePath('data'); // Liga o formulário à propriedade $data
    }

    public function authenticate()
    {
        // Pega os dados validados do formulário
        $data = $this->form->getState();

        $credentials = [
            'email' => $data['email'],
            'password' => $data['password']
        ];

        if (!Auth::attempt($credentials, $data['remember_me'])) {
            throw ValidationException::withMessages([
                'data.email' => __('auth.failed'),
            ]);
        }

        return redirect()->intended(route('home'));
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
