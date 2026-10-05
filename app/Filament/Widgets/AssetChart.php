<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use Filament\Widgets\ChartWidget;

class AssetChart extends ChartWidget
{
    protected static ?string $heading = 'Distribusi Aset per Jenis';

    protected int | string | array $columnSpan = 1;

    protected static ?int $sort = 5;

    protected static ?string $maxHeight = '300px';

    protected static bool $isLazy = false;

    protected function getData(): array
    {
        $data = Asset::query()
            ->selectRaw('jenis_aset, COUNT(*) as total')
            ->groupBy('jenis_aset')
            ->pluck('total', 'jenis_aset');

        if ($data->isEmpty()) {
            return [
                'datasets' => [
                    [
                        'label' => 'Jenis Aset',
                        'data' => [1],
                        'backgroundColor' => ['#6b7280'],
                    ],
                ],
                'labels' => ['Belum ada data'],
            ];
        }

        $labels = $data->keys()->map(fn($j) => $j ?: 'Tidak Diketahui')->toArray();
        $colors = ['#10b981', '#3b82f6', '#f59e0b', '#8b5cf6', '#ef4444', '#ec4899'];

        return [
            'datasets' => [
                [
                    'label' => 'Jenis Aset',
                    'data' => $data->values()->toArray(),
                    'backgroundColor' => array_slice($colors, 0, $data->count()),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
