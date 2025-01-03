<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getListeners(): array
    {
        return array_merge(
            parent::getListeners(),
            [
                'pedidoActualizado' => 'refrescarPedido',
            ]
        );
    }

    public function refrescarPedido()
    {
        $this->record->recalculateTotal();
        $this->record->refresh();
        $this->fillForm();
    }
}
