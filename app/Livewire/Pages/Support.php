<?php

namespace App\Livewire\Pages;

use App\Mail\SupportMail;
use App\Models\Support as ModelsSupport;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app', ['title' => 'Support'])]
class Support extends Component implements HasForms
{
    use InteractsWithForms;

    public array $data;

    public function mount(): void
    {
        $this->data = [
            'full_name' => '',
            'email' => '',
            'phone' => '',
            'subject' => '',
            'message' => '',
        ];
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('full_name')
                ->label('Nome Completo')
                ->required()
                ->columnSpanFull(),
            TextInput::make('email')
                ->label('E-mail')
                ->email()
                ->required(),
            TextInput::make('phone')
                ->label('Telefone')
                ->mask('(99) 9 9999-9999'),
            TextInput::make('subject')
                ->label('Assunto')
                ->required()
                ->columnSpanFull(),
            RichEditor::make('message')
                ->label('Mensagem')
                ->required()
                ->columnSpanFull(),
        ])->statePath('data')
        ->columns([
            'xs' => 1,
            'md' => 2
        ]);
    }

    public function send(): void
    {
        $data = $this->form->getState();

        try {
            $ticket = ModelsSupport::create($data);
            Mail::to(config('admin.users'), $data['full_name'])->send(new SupportMail($data));
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Falha ao cadastrar chamado.')
                ->body($e->getMessage())
                ->send();
        }

        Notification::make()
            ->success()
            ->title('Chamado cadastrado com sucesso!')
            ->body('Em breve alguém da nossa equipe entrará em contato com você.')
            ->send();
    }

    public function render()
    {
        return view('livewire.pages.support');
    }
}
