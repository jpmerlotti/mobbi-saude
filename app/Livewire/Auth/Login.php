<?php

namespace App\Livewire\Auth;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

#[Layout('components.layouts.simple', ['title' => 'Entrar'])]
class Login extends Component implements HasForms
{
    use InteractsWithForms;

    #[Rule('email|exists:users.email')]
    public string $email = '';

    #[Rule('required|string')]
    public string $password = '';
    
    public bool $remember_me = false;

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('email'),
            TextInput::make('password')
                ->password()
                ->revealable(),
            Checkbox::make('remember_me'),
        ]);
    }

    public function authenticate()
    {
        $credentials = [
            'email' => $this->email,
            'password' => $this->password
        ];

        if (!Auth::attempt($credentials, $this->remember_me)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        return redirect()->intended('/home');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
