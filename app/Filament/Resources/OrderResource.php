<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?int $navigationSort = 100;

    public static function getNavigationGroup(): ?string
    {
        return __('Tienda');
    }

    public static function getLabel(): ?string
    {
        return __('Pedido');
    }

    public static function getNavigationLabel(): string
    {
        return __('Pedidos');
    }

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('created_at')
                            ->label(__('Fecha'))
                            ->required(),
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Cliente')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('grand_total')
                            ->numeric(2)
                            ->label(__('Total'))
                            ->inputMode('decimal'),
                        Forms\Components\TextInput::make('currency')
                            ->label(__('Moneda'))
                            ->default('Euros'),
                        Forms\Components\TextInput::make('payment_method')
                            ->label(__('Método de pago')),
                        Forms\Components\TextInput::make('payment_status')
                            ->label(__('Estado del pago')),
                        Forms\Components\ToggleButtons::make('status')
                            ->label(__('Situación'))
                            ->inline()
                            ->required()
                            ->default('Nuevo')
                            ->colors([
                                'Nuevo' => 'primary',
                                'Procesando' => 'warning',
                                'Enviado' => 'info',
                                'Entregado' => 'success',
                                'Cancelado' => 'danger',
                            ])
                            ->icons([
                                'Nuevo' => 'heroicon-m-sparkles',
                                'Procesando' => 'heroicon-m-arrow-path',
                                'Enviado' => 'heroicon-m-truck',
                                'Entregado' => 'heroicon-m-check-badge',
                                'Cancelado' => 'heroicon-m-x-circle',
                            ]),
                        Forms\Components\TextInput::make('shipping_amount')
                            ->numeric()
                            ->label(__('Cantidad Enviada'))
                            ->inputMode('numeric'),
                        Forms\Components\TextInput::make('shipping_method')
                            ->label(__('Método de envío')),
                        Forms\Components\Textarea::make('notes')
                            ->label(__('Notas'))
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
            Tables\Columns\TextColumn::make('id')
                ->label(__('Número'))
                ->sortable()
                ->searchable()
                ->prefix('#')
                ->suffix('#')
                ->alignment(Alignment::Center),
            Tables\Columns\TextColumn::make('created_at')
                ->label(__('Fecha'))
                ->date('d-m-Y')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('user.name')
                ->label(__('Cliente'))
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('grand_total')
                ->numeric(2)
                ->label(__('Total'))
                ->alignment(Alignment::Right)
                ->searchable(),
            Tables\Columns\TextColumn::make('currency')
                ->label(__('Moneda')),
            Tables\Columns\TextColumn::make('payment_method')
                ->label(__('Método de Pago'))
                ->searchable(),
            Tables\Columns\TextColumn::make('payment_status')
                ->label(__('Estado del Pago'))
                ->searchable(),
            Tables\Columns\TextColumn::make('status')
                ->label(__('Situación'))
                ->badge()
                ->searchable()
                ->alignment(Alignment::Center)
                ->color(fn (string $state):string => match ($state) {
                    'Nuevo' => 'primary',
                    'Procesando' => 'warning',
                    'Enviado' => 'info',
                    'Entregado' => 'success',
                    'Cancelado' => 'danger',
                }),
            Tables\Columns\TextColumn::make('shipping_amount')
                ->numeric()
                ->label(__('Cantidad enviada'))
                ->alignment(Alignment::Right),
            Tables\Columns\TextColumn::make('shipping_method')
                ->label(__('Método de envío'))
                ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->label(__('Cliente'))
                    ->options(User::pluck('name', 'id'))
                    ->searchable(),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('Situación')),
            ])
            ->actions([ // Acciones sobre la línea correspondiente.
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([ // Acciones masivas sobre líneas seleccionadas.
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->emptyStateDescription(__('No hay pedidos actualmente'));
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
