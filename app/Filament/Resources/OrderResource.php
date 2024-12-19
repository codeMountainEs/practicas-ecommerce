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

    protected static ?int $navigationSort = 20;

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
                    ->columns(3)
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Cliente')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('grand_total')
                            ->numeric(2)
                            ->label(__('Total')),
                            // ->alignment(Alignment::Right)
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
                            ->default('new')
                            ->options([
                                'new' => 'Nuevo',
                                'processing' => 'En proceso',
                                'shipped' => 'Enviado',
                                'delivered' => 'Entregado',
                                'canceled' => 'Rechazado',
                            ])
                            ->colors([
                                'new' => 'primary',
                                'processing' => 'warning',
                                'shipped' => 'info',
                                'delivered' => 'success',
                                'canceled' => 'danger',
                            ])
                            ->icons([
                                'new' => 'heroicon-m-sparkles',
                                'processing' => 'heroicon-m-arrow-path',
                                'shipped' => 'heroicon-m-truck',
                                'delivered' => 'heroicon-m-check-badge',
                                'canceled' => 'heroicon-m-x-circle',
                            ]),
                        Forms\Components\TextInput::make('shipping_amount')
                            ->numeric()
                            ->label(__('Cantidad Enviada')),
                            // ->alignment(Alignment::Right)
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
                    'new' => 'primary',
                    'processing' => 'warning',
                    'shipped' => 'info',
                    'delivered' => 'success',
                    'canceled' => 'danger',
                }),
            Tables\Columns\TextColumn::make('shipping_amount')
                ->numeric()
                ->label(__('Cantidad enviada'))
                ->alignment(Alignment::Right),
            Tables\Columns\TextColumn::make('shipping_method')
                ->label(__('Método de envío'))
                ->searchable(),
/*             Tables\Columns\TextColumn::make('notes')
                ->label(__('Notas'))
                ->limit(100)
                ->searchable(),*/
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user_id')
                    ->label(__('Cliente'))
                    ->options(User::pluck('name', 'id'))
                    ->searchable(),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('Situación'))
                    ->options([
                        'new' => 'Nuevo',
                        'processing' => 'En proceso',
                        'shipped' => 'Enviado',
                        'delivered' => 'Entregado',
                        'canceled' => 'Rechazado',
                    ]),
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
            'view' => Pages\ViewOrder::route('/{record}'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
