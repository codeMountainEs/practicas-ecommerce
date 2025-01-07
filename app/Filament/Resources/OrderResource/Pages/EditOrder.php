<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\OrderItem;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Livewire\Attributes\On;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    #[On('refreshOrderLines')]
    public function updateOrder($record): void
    {
       
        $orderItem = new OrderItem($record);
       //dd( $orderItem->order);

            $order = $orderItem->order;
            $order->recalculateTotal();
            $order->refresh();

            $order->save();
            
            $this->refreshFormData(['grand_total']);
            $this->refreshFormData(['shipping_amount']);
        

      
        
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
       // dd('recalcular',  $this->record, $this->record->recalculateTotal(),$this->record->refresh());
        $this->fillForm();
    }
}
