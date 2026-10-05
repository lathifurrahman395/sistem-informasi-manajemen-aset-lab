<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    // KUNCINYA DI SINI: Memaksa halaman dashboard menyediakan 2 kolom grid di layar desktop!
    public function getColumns(): int | string | array
    {
        return [
            'md' => 2,
            'lg' => 2,
        ];
    }
}