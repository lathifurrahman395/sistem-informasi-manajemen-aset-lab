<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use App\Models\Maintenance;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class KpiOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    protected static bool $isLazy = false;   // <-- tambahkan baris ini

    protected function getStats(): array
    {
        return [
            Stat::make('Total Perangkat Lab', Asset::count())
                ->description('Semua aset yang terdata')
                ->descriptionIcon('heroicon-m-computer-desktop', IconPosition::Before)
                ->color('info'),

            Stat::make('Perbaikan Sedang Berjalan', Maintenance::where('status', 'Proses')->count())
                ->description('Perangkat sedang diperbaiki')
                ->descriptionIcon('heroicon-m-wrench-screwdriver', IconPosition::Before)
                ->color('danger'),

            Stat::make('Perangkat Nonaktif', Asset::where('status', 'Nonaktif')->count())
                ->description('rusak')
                ->descriptionIcon('heroicon-m-x-circle', IconPosition::Before)
                ->color('warning'),
        ];
    }
}
