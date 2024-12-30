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
            ->columns([
            Tables\Columns\TextColumn::make('first_name')
                ->label(__('Nombre'))
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('last_name')
                ->label(__('Apellidos'))
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('phone')
                ->label(__('Teléfono'))
                ->searchable(),
            Tables\Columns\TextColumn::make('zip_code')
                ->label(__('C.postal/Zip Code'))
                ->searchable(),
            Tables\Columns\TextColumn::make('city')
                ->label(__('Localidad/Ciudad'))
                ->searchable(),
            Tables\Columns\TextColumn::make('state')
                ->label(__('Provincia/Estado'))
                ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->emptyStateDescription(__('No hay direcciones de envío actualmente'));
    }
}
