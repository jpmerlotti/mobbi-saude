<?php

namespace App\Livewire\Pages\User\MyRentals;

use App\Enums\RentalStatus;
use App\Models\Rental;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app', ['title' => 'Meus Empréstimos'])]
class Rentals extends Component implements HasActions, HasForms
{
    use WithPagination, InteractsWithActions, InteractsWithForms;

    public string $tab = 'received';

    public function approveAction(): Action
    {
        return Action::make('approve')
            ->label('Aprovar')
            ->color('success')
            ->icon('heroicon-o-check-circle')
            ->requiresConfirmation()
            ->modalHeading('Aprovar Aluguel')
            ->modalDescription('Tem certeza que deseja aprovar esta solicitação?')
            ->modalSubmitActionLabel('Sim, Aprovar')
            ->action(function (array $arguments) {
                $rental = Rental::find($arguments['record']);

                if ($rental->owner?->id !== Auth::id()) {
                    abort(403);
                }

                $rental->update(['status' => RentalStatus::APPROVED]);

                Notification::make()
                    ->title('Solicitação Aprovada')
                    ->body("Nós informaremos ao contratante e ficará entre vocês as responsabilidades para que tudo dê certo!")
                    ->success()
                    ->send();
            });
    }

    public function rejectAction(): Action
    {
        return Action::make('reject')
            ->label('Recusar')
            ->color('danger')
            ->icon('heroicon-o-x-circle')
            ->schema([
                Textarea::make('rejection_reason')
                    ->label('Motivo da Recusa')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Explique por que não pode alugar agora...'),
            ])
            ->action(function (array $data, array $arguments) {
                $rental = Rental::find($arguments['record']);

                if ($rental->owner?->id !== Auth::id()) {
                    abort(403);
                }

                $rental->update([
                    'status' => RentalStatus::REJECTED,
                ]);

                Notification::make()
                    ->title('Solicitação Recusada')
                    ->body('O solicitante foi notificado.')
                    ->danger()
                    ->send();
            });
    }

    public function cancelAction(): Action
    {
        return Action::make('cancel')
            ->label('Cancelar')
            ->color('gray')
            ->icon('heroicon-o-trash')
            ->requiresConfirmation()
            ->action(function (array $arguments) {
                $rental = Rental::find($arguments['record']);

                if ($rental->borrower_id !== Auth::id()) {
                    abort(403);
                }

                $rental->update(['status' => RentalStatus::CANCELED]);

                Notification::make()
                    ->title('Cancelado')
                    ->body('Sua solicitação foi cancelada com sucesso.')
                    ->info()
                    ->send();
            });
    }

    #[Computed]
    public function receivedRentals()
    {
        return Rental::query()
            ->with(['borrower', 'equipment'])
            ->whereHas('equipment', fn($q) => $q->where('user_id', Auth::id()))
            ->latest()
            ->paginate(5, pageName: 'received_page');
    }

    #[Computed]
    public function sentRentals()
    {
        return Rental::query()
            ->with(['equipment.owner'])
            ->where('borrower_id', Auth::id())
            ->latest()
            ->paginate(5, pageName: 'sent_page');
    }

    public function setTab($tab)
    {
        $this->tab = $tab;
        $this->resetPage('received_page');
        $this->resetPage('sent_page');
    }

    public function render()
    {
        return view('livewire.pages.user.my-rentals.rentals');
    }
}
