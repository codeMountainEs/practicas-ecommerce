<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster;

class Users extends Cluster
{
    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?int $navigationSort = 1;
}
