<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Brand;

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
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ,
                Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm(
                        Brand::getForm()
                    )
                    ,
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
                FileUpload::make('images')
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
                        Checkbox::make('in_stock')
                            ->label(__('Hay en stock'))
                            ->columns(2),
                        Checkbox::make('is_featured')
                            ->columns(2),

                        Checkbox::make('on_sale')
                             ->columns(2)
                             ->label(__('En venta')),
                        Checkbox::make('is_active')
                            ->columns(2)
                            ->label(__('está activa')),

                        Checkbox::make('isLimited')
                            ->label(__('Tiene stock limitado')),
                     ])->columns(3)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('images')
                    ->label(__('Imagen')),
                TextColumn::make('name')
                    ->label(__('Nombre'))
                    ->description(fn (Product $producto): string => $producto->description)
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label(__('categoria'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('price')
                    ->label(__('precio'))
                    ->sortable()
                    ->money('eur'),
                IconColumn::make('in_stock')
                    ->boolean()
                    ->label(__('Stock')),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label(__('Activa')),
                IconColumn::make('is_featured')
                    ->boolean()
                    ->label(__('disponible')),
                IconColumn::make('on_sale')
                    ->boolean()
                    ->label(__('En Venta')),
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
