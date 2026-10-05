<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\ExportsCsv;
use App\Filament\Resources\MaintenanceResource\Pages;
use App\Models\Maintenance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MaintenanceResource extends Resource
{
    use ExportsCsv;

    protected static ?string $model = Maintenance::class;

    // Mengatur ikon menu di sidebar (Ikon kunci pas / perbaikan)
    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    protected static ?string $navigationLabel = 'Perbaikan Perangkat';

    protected static ?string $modelLabel = 'Data Perbaikan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Form Input Perbaikan Aset')
                    ->description('Catat detail perangkat laboratorium yang sedang atau telah selesai diperbaiki.')
                    ->schema([
                        Forms\Components\Select::make('asset_id')
                            ->relationship('asset', 'nama_perangkat') // Mengambil data nama perangkat dari tabel assets
                            ->required()
                            ->label('Pilih Perangkat Rusak')
                            ->searchable()
                            ->placeholder('Ketik nama perangkat...'),

                        Forms\Components\TextInput::make('teknisi')
                            ->label('Nama Teknisi / Toko Service')
                            ->placeholder('Contoh: CV. Aceh Komputer'),

                        Forms\Components\TextInput::make('biaya')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->label('Biaya Perbaikan'),

                        Forms\Components\Select::make('status')
                            ->options([
                                'Proses' => 'Sedang Diperbaiki',
                                'Selesai' => 'Selesai Berhasil',
                                'Gagal' => 'Gagal / Rusak Total',
                            ])
                            ->required()
                            ->default('Proses')
                            ->label('Status Perbaikan'),

                        Forms\Components\DatePicker::make('tanggal_mulai')
                            ->required()
                            ->default(now())
                            ->label('Tanggal Mulai Diperbaiki'),

                        Forms\Components\DatePicker::make('tanggal_selesai')
                            ->label('Tanggal Selesai'),

                        Forms\Components\Textarea::make('deskripsi_kerusakan')
                            ->required()
                            ->label('Deskripsi Kerusakan')
                            ->placeholder('Contoh: Monitor bergaris dan RAM minta diganti.')
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('asset.nama_perangkat')
                    ->label('Nama Perangkat')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('teknisi')
                    ->label('Teknisi')
                    ->searchable(),

                // 1. Kalkulasi Total Biaya Otomatis di Baris Paling Bawah Tabel
                Tables\Columns\TextColumn::make('biaya')
                    ->label('Biaya')
                    ->money('IDR')
                    ->sortable()
                    ->summarize(
                        Tables\Columns\Summarizers\Sum::make()
                            ->label('Total Pengeluaran')
                            ->money('IDR')
                    ),

                // 2. Status Badge dengan Tambahan Ikon Dinamis
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Proses' => 'warning',   // Kuning — dipertahankan (semantik)
                        'Selesai' => 'success',  // Hijau — dipertahankan (semantik)
                        'Gagal' => 'danger',     // Merah — dipertahankan (semantik)
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'Proses' => 'heroicon-m-arrow-path',       // Ikon Panah Berputar
                        'Selesai' => 'heroicon-m-check-circle',    // Ikon Centang
                        'Gagal' => 'heroicon-m-x-circle',          // Ikon Silang
                    })
                    ->label('Status'),

                Tables\Columns\TextColumn::make('tanggal_mulai')
                    ->label('Tgl Mulai')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            // ===== EMPTY STATE — diganti dari icon X (kesannya "error") =====
            // ke icon arsip yang lebih netral untuk kondisi "belum ada data".
            ->emptyStateIcon('heroicon-o-archive-box')
            ->emptyStateHeading('Belum ada data perbaikan')
            ->emptyStateDescription('Catatan perbaikan perangkat akan muncul di sini setelah kamu menambahkannya.')
            ->headerActions([
                static::csvExportAction(
                    filename: 'perbaikan-perangkat.csv',
                    headers: ['Nama Perangkat', 'Teknisi', 'Biaya', 'Status', 'Tanggal Mulai', 'Tanggal Selesai', 'Deskripsi Kerusakan'],
                    query: fn() => static::getModel()::query()->with('asset')->orderByDesc('tanggal_mulai')->get(),
                    rowMapper: fn($r) => [
                        $r->asset?->nama_perangkat ?? '-',
                        $r->teknisi,
                        $r->biaya,
                        $r->status,
                        optional($r->tanggal_mulai)->format('Y-m-d'),
                        optional($r->tanggal_selesai)->format('Y-m-d'),
                        $r->deskripsi_kerusakan,
                    ],
                ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMaintenances::route('/'),
            'create' => Pages\CreateMaintenance::route('/create'),
            'edit' => Pages\EditMaintenance::route('/{record}/edit'),
        ];
    }
}
