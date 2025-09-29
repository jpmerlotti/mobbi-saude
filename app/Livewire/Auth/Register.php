<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('components.layouts.simple', ['title' => 'Registre-se'])]
class Register extends Component implements HasForms
{
    use InteractsWithForms;

    #[Rule('required|string|min:3|max:100')]
    public string $name = '';

    #[Rule('required|string|email|unique:users,email')]
    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public function register()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ];

        $user = User::create($data);

        Auth::login($user);
        return redirect()->intended(route('home'));
    }

    public function form(Schema $shcema): Schema
    {
        return $shcema->components([
            TextInput::make('name'),
            TextInput::make('email'),
            TextInput::make('password')
                ->password()
                ->same('password_confirmation')
                ->revealable(),
            TextInput::make('password_confirmation')
                ->password()
                ->revealable(),
        ]);
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
