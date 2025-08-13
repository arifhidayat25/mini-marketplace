<?php

namespace App\Filament\Resources\ConversationResource\Pages;

use App\Filament\Resources\ConversationResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;


class ViewConversation extends ViewRecord implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = ConversationResource::class;
    

    protected static string $view = 'filament.resources.conversation-resource.pages.view-conversation';

    public ?array $data = [];

    

    public function mount($record): void
    {
        parent::mount($record);
        $this->form->fill();
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('reply')
                    ->label('Balas Pesan')
                    ->placeholder('Ketik balasan Anda...')
                    ->required(),
            ])
            ->statePath('data');
    }

    // =======================================================
    // == TAMBAHKAN METHOD INI UNTUK MEMPERBAIKI ERROR ==
    // =======================================================
    public function getFormStatePath(): string
    {
        return 'data';
    }
    // =======================================================
    
    protected function getFooterActions(): array
    {
        return [
            Action::make('sendReply')
                ->label('Kirim')
                ->submit('sendReply'),
        ];
    }

    public function sendReply(): void
    {
        $formData = $this->form->getState();
        
        $this->record->messages()->create([
            'user_id' => null, // null menandakan pesan dari admin
            'body' => $formData['reply'],
        ]);
        
        $this->form->fill();
    }
}