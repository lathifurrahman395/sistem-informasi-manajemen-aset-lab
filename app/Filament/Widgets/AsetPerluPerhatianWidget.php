<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class AsetPerluPerhatianWidget extends BaseWidget
{
    protected static ?int $sort = 4;

    public function getHeading(): ?string
    {
        return 'Aset Perlu Perhatian';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                // FIX: nilai status yang tersimpan di database pakai huruf kapital
                // di awal ('Nonaktif', 'Rusak', 'Perbaikan'), sesuai yang tampil di
                // tabel Asset dan default migration ('Aktif'). Sebelumnya query ini
                // pakai huruf kecil semua sehingga tidak pernah cocok (terutama di
                // SQLite yang perbandingan stringnya case-sensitive).
                Asset::query()->whereIn('status', ['Rusak', 'Nonaktif', 'Perbaikan'])
            )
            ->columns([
                Tables\Columns\TextColumn::make('kode_aset')->label('Kode Aset'),
                Tables\Columns\TextColumn::make('nama_perangkat')->label('Nama Perangkat'),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Rusak' => 'danger',
                        'Perbaikan' => 'warning',
                        'Nonaktif' => 'gray',
                        default => 'gray',
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Ubah'),
            ])
            ->paginated(false)
            ->emptyStateHeading('Semua aset dalam kondisi baik')
            ->emptyStateDescription('Tidak ada aset yang butuh perhatian saat ini.')
            ->emptyStateIcon('heroicon-o-check-circle');
    }
}
