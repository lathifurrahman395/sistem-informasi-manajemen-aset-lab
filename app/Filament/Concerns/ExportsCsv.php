<?php

namespace App\Filament\Concerns;

use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;

trait ExportsCsv
{
    /**
     * Buat tombol "Cetak CSV" untuk header aksi tabel Filament.
     *
     * @param  string   $filename    Nama file yang akan di-download, misal 'aset.csv'
     * @param  array    $headers     Judul kolom CSV, misal ['Nama', 'Lokasi', 'Status']
     * @param  \Closure $query       Closure yang mengembalikan Builder/collection data, misal fn () => static::getModel()::query()->with('location')->get()
     * @param  \Closure $rowMapper   Closure yang mengubah 1 record jadi array baris CSV, misal fn ($r) => [$r->nama, $r->location->nama_laboratorium, $r->status]
     */
    protected static function csvExportAction(string $filename, array $headers, \Closure $query, \Closure $rowMapper): Action
    {
        return Action::make('exportCsv')
            ->label('Cetak CSV')
            ->icon('heroicon-o-arrow-down-tray')
            ->color('gray')
            ->action(function () use ($filename, $headers, $query, $rowMapper) {
                $records = $query();

                return response()->streamDownload(function () use ($records, $headers, $rowMapper) {
                    $out = fopen('php://output', 'w');

                    // BOM biar Excel baca UTF-8 (karakter é, ü, dll) dengan benar
                    fwrite($out, "\xEF\xBB\xBF");

                    fputcsv($out, $headers);

                    foreach ($records as $record) {
                        fputcsv($out, $rowMapper($record));
                    }

                    fclose($out);
                }, $filename);
            });
    }
}
