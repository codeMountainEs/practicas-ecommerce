<?php

namespace App\Livewire\Inicio;

use App\Models\Product;
use Livewire\Component;

class Imagenes extends Component
{
    public function render()
    {


        $products = Product::where('is_active', '1')->get();


        return view('livewire.inicio.imagenes',[
            'products' => $products,
        ]);
    }
}
