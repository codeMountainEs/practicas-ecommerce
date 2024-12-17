<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?int $navigationSort= 10;

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
                    ->label(__('Imagen'))
                    ->Image()
                    ->maxSize(4096)
                    ->placeholder(__('Imagen del producto'))
                    ->columnSpanFull(),
                Grid::make()
                    ->schema([
                        TextInput::make('price')
                            ->required()
                            ->minLength(2)
                            ->maxLength(200)
                            ->label(__('Precio'))
                            ->Columns(2),
                        TextInput::make('stock')
                            ->minLength(1)
                            ->maxLength(200)
                            ->columns(2),
                    ])->columns(3),
                    Checkbox::make('isLimited')
                        ->label(__('Tiene stock limitado')),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('Image')
                    ->label(__('Imagem')),
                TextColumn::make('name')
                    ->label(__('Nombre'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('description')
                    ->label(__('Descripción'))
                    ->limit(50)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label(__('precio'))
                    ->sortable()
                    ->money('eur'),
                TextColumn::make('isLimited')
                    ->label(__('Stock'))
                    ->formatStateUsing( fn (Product $product)=> $product->isLimited? $product->stock : 'No'),
                textColumn::make('created_at')
                    ->label(__('Creado'))
                    ->sortable()
                    ->date('d/m/Y h:i'),
                textColumn::make('updated_at')
                    ->label(__('Actualizacion'))
                    ->sortable()
                    ->date('d/m/Y h:i')
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
                ])
            ])
            ->emptyStateDescription(__('No hay registros'));
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
