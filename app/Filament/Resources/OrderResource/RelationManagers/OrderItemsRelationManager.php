<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Enums\ValoresMinMax;
use App\Models\OrderItem;
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
use Livewire\Component;

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
                            ->afterStateUpdated(function (Forms\Components\Select $component, Forms\Set $set, Forms\Get $get) {
                                $product = Product::query()
                                    ->where('id', $component->getState())
                                    ->first();
                                $set('unit_amount', $product?->price ?? 0);
                                self::updateTotals($get, $set);
                            }),
                        Forms\Components\TextInput::make('quantity')
                            ->integer()
                            ->label(__('Cantidad'))
                            ->default(1)
                            ->minValue(ValoresMinMax::minCantidad->valorInt())
                            ->maxValue(ValoresMinMax::maxCantidad->valorInt())
                            ->reactive()
                            ->live(onBlur: true)
                            ->extraInputAttributes(['style' => 'text-align: right;'])
                            ->afterStateUpdated(
                                function(Forms\Set $set, Forms\Get $get) {
                                    self::updateTotals($get, $set);
                                }
                            ),
                        Forms\Components\TextInput::make('unit_amount')
                            ->label(__('Precio unitario'))
                            ->numeric()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(ValoresMinMax::maxImporte->valorFloat())
                            ->extraInputAttributes(['style' => 'text-align: right;'])
                            ->readonly(),
                        Forms\Components\TextInput::make('total_amount')
                            ->label(__('Importe Total'))
                            ->numeric()
                            ->default(0)
                            ->minValue(ValoresMinMax::minImporte->valorFloat())
                            ->maxValue(ValoresMinMax::maxImporte->valorFloat())
                            ->extraInputAttributes(['style' => 'text-align: right;'])
                            ->readonly(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
        ->recordTitleAttribute('id')
        ->columns([
            Tables\Columns\TextColumn::make('id')
                ->label(__('Línea'))
                ->sortable()
                ->searchable()
                ->prefix('#')
                ->suffix('#')
                ->alignment(Alignment::Center),
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
                Tables\Actions\CreateAction::make()
                ->label('nueva')
                ->after(function (Component $livewire, OrderItem $orderItem) {
                   // dd($orderItem); 
                    $livewire->dispatch('refreshOrderLines',$orderItem); 
                }),
              
            ])
            ->actions([

                Tables\Actions\EditAction::make()
                ->successNotificationTitle('Registro Actualizado')
                ->modalHeading('Editar Línea de pedido')
                ->after(function (Component $livewire, OrderItem $orderItem) {
                    
              
                    //dd('orderItem',$livewire->ownerRecord->update(['grand_total' => 999]),$livewire);
                   

                    $livewire->dispatch('refreshOrderLines',  $orderItem); 
                   // $livewire->dispatch('pedidoActualizado'); 
                    //$livewire->ownerRecord->update(['grand_total' => 999]);
                    

                }),
                
                Tables\Actions\DeleteAction::make()
                ->modalHeading('Borrar Línea de pedido')
                ->after(function (Component $livewire, OrderItem $orderItem) {
                    $livewire->dispatch('refreshOrderLines', $orderItem); 
                }),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                ->after(function (Component $livewire, OrderItem $orderItem) {
                    $livewire->dispatch('refreshOrderLines',  $orderItem); 
                }),

            ])
            ->emptyStateDescription(__('No hay líneas de pedidos actualmente'));
    }

    public static function updateTotals($get, $set): void
    {
        $cantidad = $get('quantity');
        $precio = $get('unit_amount');
        if (is_numeric($cantidad) && is_numeric($precio)) {
            $importe = $cantidad*$precio;
        } else {
            $importe = 0;
        }
        $set('total_amount', $importe);
    }
}