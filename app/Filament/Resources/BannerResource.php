<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Filament\Resources\BannerResource\RelationManagers;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            FileUpload::make('image_url')
                ->label('Banner Image')
                ->image() // Memastikan ini adalah gambar
                ->directory('banners') // Simpan di folder storage/app/public/banners
                ->required()
                ->columnSpanFull(),
            TextInput::make('title')
                ->required()
                ->maxLength(255),
            TextInput::make('link_url')
                ->label('Link URL')
                ->url() // Validasi sebagai URL
                ->maxLength(255),
            Toggle::make('is_active')
                ->label('Active')
                ->default(true),
            TextInput::make('order')
                ->label('Display Order')
                ->numeric()
                ->default(0),
        ]);
}

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            ImageColumn::make('image_url')->label('Image'),
            TextColumn::make('title')->searchable(),
            IconColumn::make('is_active')->boolean(),
            TextColumn::make('order')->sortable(),
        ])
        ->defaultSort('order', 'asc') // Urutkan berdasarkan kolom 'order'
        ->filters([
            //
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            // ...
        ]);
}

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
