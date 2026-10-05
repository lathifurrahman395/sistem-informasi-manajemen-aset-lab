<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\ExportsCsv;
use App\Filament\Resources\AssetResource\Pages;
use App\Models\Asset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AssetResource extends Resource
{
    use ExportsCsv;

    protected static ?string $model = Asset::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    protected static ?string $navigationLabel = 'Manajemen Aset';

    // ===== GLOBAL SEARCH =====
    protected static ?string $recordTitleAttribute = 'nama_perangkat';

    public static function getGloballySearchableAttributes(): array
    {
        return ['kode_aset', 'nama_perangkat', 'jenis_aset'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Kode Aset' => $record->kode_aset,
            'Lokasi' => $record->location?->nama_lab ?? '-',
            'Status' => $record->status,
        ];
    }

    public static function getGlobalSearchResultUrl($record): string
    {
        return static::getUrl('edit', ['record' => $record]);
    }
    // ===== END GLOBAL SEARCH =====

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Detail Aset / Perangkat')
                    ->description('Masukkan data spesifikasi perangkat laboratorium komputer secara akurat.')
                    ->schema([
                        Forms\Components\TextInput::make('kode_aset')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->extraInputAttributes(['style' => 'text-transform: uppercase'])
                            ->mutateDehydratedStateUsing(fn(string $state): string => strtoupper($state))
                            ->label('Kode Rekam Aset')
                            ->placeholder('Contoh: 001'),

                        Forms\Components\TextInput::make('nama_perangkat')
                            ->required()
                            ->label('Nama Perangkat / Spesifikasi')
                            ->placeholder('Contoh: PC Main Lab Core i5 RAM 16GB'),

                        Forms\Components\Select::make('location_id')
                            ->relationship('location', 'nama_lab')
                            ->label('Lokasi Penempatan Ruang Lab')
                            ->placeholder('Pilih Ruangan Lab')
                            ->searchable()
                            ->preload(),

                        Forms\Components\TextInput::make('jenis_aset')
                            ->placeholder('Contoh: Hardware, Software, Network Device')
                            ->label('Jenis / Kategori Aset'),

                        Forms\Components\Select::make('status')
                            ->options([
                                'Aktif' => 'Aktif / Digunakan',
                                'Nonaktif' => 'Nonaktif / Rusak',
                            ])
                            ->required()
                            ->default('Aktif')
                            ->label('Status Operasional'),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode_aset')
                    ->label('Kode Aset')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_perangkat')
                    ->label('Nama Perangkat')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('location.nama_lab')
                    ->label('Lokasi Lab')
                    ->default('Belum Ditentukan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('jenis_aset')
                    ->label('Jenis Aset')
                    // Kurang krusial di layar HP, disembunyikan default, tapi bisa
                    // dimunculkan manual lewat ikon toggle kolom di pojok tabel.
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Aktif' => 'success',
                        'Nonaktif' => 'danger',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'Aktif' => 'heroicon-m-computer-desktop',
                        'Nonaktif' => 'heroicon-m-exclamation-triangle',
                    })
                    ->label('Status'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                static::csvExportAction(
                    filename: 'manajemen-aset.csv',
                    headers: ['Kode Aset', 'Nama Perangkat', 'Lokasi Lab', 'Jenis Aset', 'Status'],
                    query: fn () => static::getModel()::query()->with('location')->orderBy('kode_aset')->get(),
                    rowMapper: fn ($r) => [
                        $r->kode_aset,
                        $r->nama_perangkat,
                        $r->location?->nama_lab ?? 'Belum Ditentukan',
                        $r->jenis_aset,
                        $r->status,
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
            'index' => Pages\ListAssets::route('/'),
            'create' => Pages\CreateAsset::route('/create'),
            'edit' => Pages\EditAsset::route('/{record}/edit'),
        ];
    }
}