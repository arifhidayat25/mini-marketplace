<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConversationResource\Pages;
use App\Models\Conversation;
use App\Models\Message;
use Filament\Forms;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ConversationResource extends Resource
{
    protected static ?string $model = Conversation::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Chat Pelanggan';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produk')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('messages.body')
                    ->label('Pesan Terakhir')
                    ->getStateUsing(fn (Conversation $record) => $record->messages()->latest()->first()?->body)
                    ->words(8),

                // ICON UNTUK PESAN BELUM DIBACA SEKARANG DI SINI
                Tables\Columns\IconColumn::make('has_unread_messages')
                    ->label('Baru')
                    ->boolean()
                    ->getStateUsing(function (Conversation $record) {
                        // Cek apakah ada pesan dari user (bukan admin) yang belum dibaca
                        return $record->messages()->where('user_id', '!=', null)->whereNull('read_at')->exists();
                    })
                    ->trueIcon('heroicon-s-envelope')
                    ->color('danger'),
                    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diperbarui')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->actions([
                Tables\Actions\Action::make('chat')
                    ->label('Lihat Chat')
                    ->url(fn (Conversation $record): string => static::getUrl('chat', ['record' => $record]))
                    ->icon('heroicon-o-chat-bubble-bottom-center-text'),
            ])
            ->bulkActions([]);
    }
    
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Info Produk')
                    ->schema([
                        Infolists\Components\TextEntry::make('product.name')
                            ->label('Percakapan tentang produk:'),
                    ])->columns(1),

                // GANTI REPEATABLE ENTRY YANG LAMA DENGAN INI
                Infolists\Components\ViewEntry::make('messages')
                    ->label('Percakapan')
                    ->view('filament.infolists.chat-bubble')
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListConversations::route('/'),
            'chat' => Pages\Chat::route('/{record}/chat'),

        ];
    }
}