<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
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
use Filament\Support\RawJs;
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
                        Forms\Components\TextInput::make('id')
                            ->label(__('Número Pedido'))
                            ->disabled(),
                        Forms\Components\DatePicker::make('created_at')
                            ->label(__('Fecha'))
                            ->autofocus()
                            ->required(),
                        Forms\Components\Select::make('user_id')
                            ->label('Cliente')
                            ->placeholder(__('Selecciona un Cliente'))
                            ->options(
                                User::query()
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                            )
                            ->required()
                            ->searchable()
                            ->reactive()
                            ->preload(),
                        Forms\Components\ToggleButtons::make('status')
                            ->label(__('Situación'))
                            ->inline()
                            ->required()
                            ->default(OrderStatus::Nuevo)
                            ->options(OrderStatus::class),
                        Forms\Components\TextInput::make('grand_total')
                            ->label(__('Total'))
                            ->numeric()
                            ->default(0)
                            ->mask(RawJs::make('$money($input)'))
                            ->stripCharacters(',')
                            ->disabled(),
                        Forms\Components\TextInput::make('currency')
                            ->label(__('Moneda'))
                            ->maxLength(255)
                            ->default('Euros'),
                        Forms\Components\TextInput::make('payment_method')
                            ->label(__('Método de pago'))
                            ->maxLength(255),
                        Forms\Components\TextInput::make('payment_status')
                            ->label(__('Estado del pago'))
                            ->maxLength(255),
                        Forms\Components\TextInput::make('shipping_amount')
                            ->integer()
                            ->label(__('Cantidad Enviada'))
                            ->default(0)
                            ->disabled(),
                        Forms\Components\TextInput::make('shipping_method')
                            ->label(__('Método de envío'))
                            ->maxLength(255),
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
                ->date('d/m/Y')
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
                    'Nuevo' => 'gray',
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
                    ->placeholder(__('Selecciona un Cliente'))
                    ->options(
                        User::query()
                            ->orderBy('name')
                            ->pluck('name', 'id')
                    )
                    ->searchable(),
                Tables\Filters\SelectFilter::make('status')
                    ->label(__('Situación'))
                    ->options(OrderStatus::class),
            ])
            ->actions([ // Acciones sobre la línea correspondiente.
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            RelationManagers\OrderItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
