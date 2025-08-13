<?php

namespace App\Filament\Resources\ConversationResource\Pages;

use App\Filament\Resources\ConversationResource;
use App\Models\Conversation;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;

class Chat extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = ConversationResource::class;

    protected static string $view = 'filament.resources.conversation-resource.pages.chat';

    public Conversation $record;
    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('body')
                    ->placeholder('Ketik balasan Anda...')
                    ->required(),
            ])
            ->statePath('data');
    }

    public function sendMessage(): void
    {
        $formData = $this->form->getState();

        $this->record->messages()->create([
            'user_id' => null, // null = admin
            'body' => $formData['body'],
        ]);

        $this->form->fill();
    }
}