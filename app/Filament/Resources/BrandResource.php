<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Brand;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BrandResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BrandResource\RelationManagers;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort= 30;
    public static function getNavigationGroup(): ?string
    {
        return __('Almacén');
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            TextInput::make('name')
                ->autofocus()
                ->required()
                ->minLength(3)
                ->maxLength(200)
                ->unique(static::getModel(), 'name', ignoreRecord: true)
                ->label(__('Nombre'))
                ->columnSpanFull(),
            Textarea::make('description')
                ->label(__('Descripción'))
                ->rows(3)
                ->columnSpanFull(),
            FileUpload::make('image')
                ->label(__('Logo'))
                ->Image()
                ->maxSize(4096)
                ->placeholder(__('Imagen del logo'))
                ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            ImageColumn::make('Image')
                ->label(__('Logo')),
            TextColumn::make('name')
                ->label(__('Nombre'))
                ->searchable()
                ->sortable(),
            TextColumn::make('description')
                ->label(__('Descripción'))
                ->limit(50)
                ->searchable()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
