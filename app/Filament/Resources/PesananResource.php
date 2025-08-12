<?php

namespace App\Filament\Resources;

// 1. PASTIKAN USE STATEMENTS INI BENAR DAN LENGKAP
use App\Filament\Resources\PesananResource\Pages;
use App\Filament\Resources\PesananResource\RelationManagers;
use App\Models\Pesanan; // <-- INI YANG PALING PENTING
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class PesananResource extends Resource
{
    // 2. PASTIKAN MODEL MENUNJUK KE KELAS YANG BENAR
    protected static ?string $model = Pesanan::class;

    protected static ?string $navigationLabel = 'Pesanan';
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $modelLabel = 'Pesanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Pesanan')->schema([
                    TextInput::make('name')->label('Nama Pelanggan')->disabled(),
                    TextInput::make('email')->disabled(),
                    TextInput::make('phone')->label('Telepon')->disabled(),
                    TextInput::make('total_price')->prefix('Rp')->disabled(),
                    TextInput::make('created_at')->label('Tanggal Pesan')->disabled(),
                    Select::make('status')->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])->required(),
                    Forms\Components\Textarea::make('address')->label('Alamat Pengiriman')->disabled()->columnSpanFull(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable(),
                TextColumn::make('name')->label('Nama Pelanggan')->searchable(),
                TextColumn::make('total_price')->money('IDR')->sortable(),
                BadgeColumn::make('status')->colors([
                    'warning' => 'pending',
                    'primary' => 'processing',
                    'success' => 'completed',
                    'danger' => 'cancelled',
                ]),
                TextColumn::make('created_at')->label('Tanggal Pesan')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        // Relation manager akan kita perbaiki setelah ini
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPesanans::route('/'),
            'create' => Pages\CreatePesanan::route('/create'),
            'edit' => Pages\EditPesanan::route('/{record}/edit'),
        ];
    }
}