<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Component;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'address';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('Dirección de envío del pedido #:id#', ['id' => $ownerRecord->id]);
    }

    protected static function getRecordLabel(): ?string
    {
        return __('Dirección de envío del pedido');
    }

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\Hidden::make('order_id')
                ->default($this->ownerRecord->id),
            Forms\Components\Grid::make()
                ->columns(3)
                ->schema([
                    Forms\Components\TextInput::make('first_name')
                        ->label(__('Nombre'))
                        ->maxLength(255)
                        ->required(),
                    Forms\Components\TextInput::make('last_name')
                        ->label(__('Apellidos'))
                        ->maxLength(255)
                        ->required(),
                    Forms\Components\TextInput::make('phone')
                        ->label(__('Teléfono'))
                        ->tel()
                        ->maxLength(20)
                        ->required(),
                    Forms\Components\Textarea::make('street_address')
                        ->label(__('Dirección'))
                        ->required()
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('zip_code')
                        ->label(__('C.postal/Zip Code'))
                        ->maxLength(10)
                        ->required(),
                    Forms\Components\TextInput::make('city')
                        ->label(__('Localidad/Ciudad'))
                        ->maxLength(255)
                        ->required(),
                    Forms\Components\TextInput::make('state')
                        ->label(__('Provincia/Estado'))
                        ->maxLength(255)
                        ->required(),
                ]),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->paginated(false)
            ->columns([
            Tables\Columns\TextColumn::make('nombre_completo')
                ->label(__('Nombre y Apellidos')),
            Tables\Columns\TextColumn::make('phone')
                ->label(__('Teléfono')),
            Tables\Columns\TextColumn::make('zip_code')
                ->label(__('C.postal/Zip Code')),
            Tables\Columns\TextColumn::make('city')
                ->label(__('Localidad/Ciudad')),
            Tables\Columns\TextColumn::make('state')
                ->label(__('Provincia/Estado')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Editar Dirección de envío del pedido'),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->createAnother(false)
                    ->after(function (Component $livewire) {
                        $livewire->dispatch('pedidoActualizado');
                    }),
            ])
            ->emptyStateDescription(__('No hay direcciones de envío actualmente'));
    }
}
