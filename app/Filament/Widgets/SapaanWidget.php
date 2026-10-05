<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Carbon\Carbon;

class SapaanWidget extends Widget
{
    protected static string $view = 'filament.widgets.sapaan-widget';
    protected static ?int $sort = 1;
    protected int | string | array $columnSpan = 'full';

    // Auto-refresh tiap 60 detik supaya sapaan ikut berubah realtime
    // tanpa perlu reload manual.
    protected static ?string $pollingInterval = '60s';

    public function getSapaan(): string
    {
        // Paksa timezone WIB (Asia/Jakarta) di sini, tidak bergantung
        // pada config('app.timezone') server yang mungkin masih UTC.
        $jam = Carbon::now('Asia/Jakarta')->hour;

        return match (true) {
            $jam < 11 => 'Selamat Pagi',
            $jam < 15 => 'Selamat Siang',
            $jam < 18 => 'Selamat Sore',
            default => 'Selamat Malam',
        };
    }
}
