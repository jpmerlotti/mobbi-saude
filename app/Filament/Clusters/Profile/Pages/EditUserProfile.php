<?php

namespace App\Filament\Clusters\Profile\Pages;

use App\Filament\Clusters\Profile;
use App\Models\User;
use App\Services\Auth\UserService;
use Exception;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class EditUserProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationLabel = 'Perfil do Usuário';

    protected static ?string $slug = 'me';

    protected ?string $heading = '';

    protected ?string $subheading = '';

    protected static string $view = 'filament.clusters.profile.pages.edit-user-profile';

    protected static ?int $navigationSort = 1;

    protected static ?string $cluster = Profile::class;

    public function getTitle(): string|Htmlable
    {
        return self::$navigationLabel;
    }

    public ?array $data = [
        'name' => null,
        'email' => null,
    ];

    protected User $user;

    public function mount(): void
    {
        $this->user = auth()->user();

        $this->data['name'] = $this->user->name;
        $this->data['email'] = $this->user->email;
        $this->data['phone'] = $this->user->phone;
        $this->data['document'] = $this->user->document;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Seu Perfil')
                    ->description('Você pode atualizar suas informações aqui.')
                    ->icon('heroicon-o-user')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email')
                            ->required(),
                        PhoneNumber::make('phone')
                            ->label('Telefone')
                            ->required(),
                        Document::make('document')
                            ->label('Documento')
                            ->dynamic()
                    ]),
            ])
            ->statePath('data');
    }

    public function update(): void
    {
        try {
            $data = $this->form->getState(); //@phpstan-ignore-line

            $service = new UserService;

            $service->update(auth()->user(), $data);
        } catch (Exception $exception) {
            Notification::make()
                ->danger()
                ->title('Ocorreu um erro ao atualizar as informações do perfil')
                ->send();

            return;
        }

        Notification::make()
            ->success()
            ->title('Informações do perfil atualizadas com sucesso')
            ->send();
    }
}
