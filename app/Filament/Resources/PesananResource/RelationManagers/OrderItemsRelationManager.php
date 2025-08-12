<?php

namespace App\Filament\Resources\PesananResource\RelationManagers;

use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItems';
    protected static ?string $title = 'Item Produk'; // Judul tabel

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')->label('Produk'),
                TextColumn::make('quantity')->label('Jumlah'),
                TextColumn::make('price')->money('IDR')->label('Harga per Item'),
            ]);
    }
}