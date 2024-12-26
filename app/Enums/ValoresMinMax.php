<?php

namespace App\Enums;

enum ValoresMinMax: string
{
    case maxImporte = '99999999.99';

    case minImporte = '-99999999.99';

    case maxCantidad = '2147483647';

    case minCantidad = '-2147483648';

    public function valorFloat(): float
    {
        return (float) $this->value;
    }

    public function valorInt(): float
    {
        return (int) $this->value;
    }
}
