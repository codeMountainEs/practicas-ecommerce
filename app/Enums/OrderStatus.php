<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum OrderStatus: string implements HasColor, HasIcon, HasLabel
{

    case Nuevo = 'Nuevo';

    case Procesando = 'Procesando';

    case Enviado = 'Enviado';

    case Entregado = 'Entregado';

    case Cancelado = 'Cancelado';

    public function getLabel(): string
    {
        return match ($this) {
            self::Nuevo => 'Nuevo',
            self::Procesando => 'Procesando',
            self::Enviado => 'Enviado',
            self::Entregado => 'Entregado',
            self::Cancelado => 'Cancelado',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Nuevo => 'gray',
            self::Procesando => 'warning',
            self::Enviado => 'info',
            self::Entregado => 'success',
            self::Cancelado => 'danger',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Nuevo => 'heroicon-m-sparkles',
            self::Procesando => 'heroicon-m-arrow-path',
            self::Enviado => 'heroicon-m-truck',
            self::Entregado => 'heroicon-m-check-badge',
            self::Cancelado => 'heroicon-m-x-circle',
        };
    }
}
