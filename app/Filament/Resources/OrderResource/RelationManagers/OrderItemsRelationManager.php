<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItems';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Líneas del pedido #:id#', ['id' => $ownerRecord->id]);
    }

    protected static function getRecordLabel(): ?string
    {
        return __('Línea de pedido');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('order_id')
                    ->default($this->ownerRecord->id),
                Forms\Components\Grid::make()
                    ->columns(4)
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->label(__('Producto'))
                            ->placeholder(__('Escoja un producto'))
                            ->options(
                                Product::query()
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                            )
                            ->required()
                            ->searchable()
                            ->reactive()
                            ->preload()
                            ->afterStateUpdated(function (Forms\Components\Select $component, Forms\Set $set) {
                                $product = Product::query()
                                    ->where('id', $component->getState())
                                    ->first();
                                $set('unit_amount', $product?->price ?? 0);
                            })
                            ->afterStateUpdated(
                                fn(Forms\Set $set, Forms\Get $get)
                                =>
                                $set('total_amount', $get('quantity')*$get('unit_amount'))
                            ),
                        Forms\Components\TextInput::make('quantity')
                            ->numeric()
                            ->label(__('Cantidad'))
                            ->default(1)
                            ->inputMode('numeric')
                            ->minValue(-2147483648)
                            ->maxValue(2147483647)
                            ->afterStateUpdated(
                                fn($state,Forms\Set $set, Forms\Get $get)
                                =>
                                $set('total_amount', $state*$get('unit_amount'))
                            ),
                        Forms\Components\TextInput::make('unit_amount')
                            ->label(__('Precio unitario'))
                            ->numeric()
                            ->inputMode('decimal')
                            ->readonly(),
                        Forms\Components\TextInput::make('total_amount')
                            ->label(__('Importe Total'))
                            ->numeric()
                            ->inputMode('decimal')
                            ->readonly(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
        ->recordTitleAttribute('id')
        ->columns([
            Tables\Columns\TextColumn::make('product.name')
                ->label(__('Producto'))
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('quantity')
                ->numeric()
                ->label(__('Cantidad'))
                ->alignment(Alignment::Right)
                ->searchable(),
            Tables\Columns\TextColumn::make('unit_amount')
                ->numeric(2)
                ->label(__('Precio unitario'))
                ->alignment(Alignment::Right)
                ->searchable(),
            Tables\Columns\TextColumn::make('total_amount')
                ->numeric(2)
                ->label(__('Importe total'))
                ->alignment(Alignment::Right)
                ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('product_id')
                ->label(__('Producto'))
                ->placeholder(__('Escoja un producto'))
                ->options(
                    Product::query()
                        ->orderBy('name')
                        ->pluck('name', 'id')
                )
                ->searchable(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->emptyStateDescription(__('No hay líneas de pedidos actualmente'));
    }
}
