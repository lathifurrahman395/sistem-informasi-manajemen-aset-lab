<?php

namespace App\Filament\Resources\AdminResource\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Schema;

class LatestMaintenancesTable extends BaseWidget
{
    // Ganti bagian properti columnSpan lama dengan ini:
    // Memaksa tabel hanya memakan 1 kolom (setengah layar) saat di desktop
    protected int | string | array $columnSpan = 1;

    protected static ?string $heading = 'Aktivitas Perbaikan Perangkat Terakhir';

    public function table(Table $table): Table
    {
        // Deteksi kolom nama perangkat/barang secara dinamis agar aman dari error sql
        $assetColumn = Schema::hasColumn('maintenances', 'nama_perangkat')
            ? 'nama_perangkat'
            : (Schema::hasColumn('maintenances', 'nama_barang') ? 'nama_barang' : 'keterangan_kerusakan');

        // Deteksi secara otomatis class model mana yang aktif di proyekmu
        $modelClass = class_exists(\App\Models\Maintenance::class)
            ? \App\Models\Maintenance::class
            : \App\Models\Maintenance::class;

        return $table
            ->query(
                $modelClass::query()->latest()->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->date('d M Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make($assetColumn)
                    ->label('Perangkat / Keterangan')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Selesai' => 'success',
                        'Proses', 'Diproses' => 'warning',
                        'Gagal' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->actions([
                Tables\Actions\Action::make('cek')
                    ->label('Detail')
                    ->icon('heroicon-m-eye')
                    ->url(fn($record): string => url("/admin/maintenances/{$record->id}/edit")),
            ]);
    }
}
