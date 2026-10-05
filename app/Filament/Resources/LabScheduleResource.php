<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\ExportsCsv;
use App\Filament\Resources\LabScheduleResource\Pages;
use App\Models\Location;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rules\Unique;

class LabScheduleResource extends Resource
{
    use ExportsCsv;

    protected static ?string $model = 'App\\Models\\LabSchedule';

    protected static ?string $navigationLabel = 'Jadwal Penggunaan';
    protected static ?string $pluralModelLabel = 'Jadwal Penggunaan Lab';
    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    // ===== GLOBAL SEARCH =====
    protected static ?string $recordTitleAttribute = 'keperluan';

    public static function getGloballySearchableAttributes(): array
    {
        return ['keperluan', 'user_name', 'hari', 'waktu'];
    }

    public static function getGlobalSearchResultDetails($record): array
    {
        return [
            'Hari / Jam' => "{$record->hari}, {$record->waktu}",
            'Lab' => $record->location?->nama_lab ?? '-',
            'Dosen' => $record->user_name,
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
                Forms\Components\Section::make('Detail Jadwal Penggunaan Lab')
                    ->schema([
                        Forms\Components\Select::make('location_id')
                            ->relationship('location', 'nama_lab')
                            ->label('Laboratorium')
                            ->searchable()
                            ->preload()
                            ->live() // supaya validasi bentrok langsung update saat lab diganti
                            ->required(),

                        Forms\Components\Select::make('hari')
                            ->label('Hari')
                            ->options([
                                'Senin' => 'Senin',
                                'Selasa' => 'Selasa',
                                'Rabu' => 'Rabu',
                                'Kamis' => 'Kamis',
                                'Jumat' => 'Jumat',
                            ])
                            ->live() // supaya validasi bentrok langsung update saat hari diganti
                            ->required(),

                        Forms\Components\TextInput::make('waktu')
                            ->label('Slot Waktu (Jam)')
                            ->placeholder('Contoh: 08:00 - 10:30')
                            ->required()
                            // ===== VALIDASI BENTROK JADWAL (DOUBLE BOOKING) =====
                            // Kombinasi location_id + hari + waktu harus unik.
                            // Kalau ketiganya sama persis dengan jadwal lain, ditolak.
                            ->unique(
                                table: 'lab_schedules',
                                column: 'waktu',
                                ignoreRecord: true,
                                modifyRuleUsing: function (Unique $rule, Get $get) {
                                    return $rule
                                        ->where('location_id', $get('location_id'))
                                        ->where('hari', $get('hari'));
                                },
                            )
                            ->validationMessages([
                                'unique' => 'Jadwal bentrok! Lab dan jam ini sudah dipakai untuk hari yang sama.',
                            ])
                            ->helperText('Sistem otomatis menolak jika lab + hari + jam sudah ada jadwal lain.'),

                        Forms\Components\TextInput::make('keperluan')
                            ->label('Mata Kuliah / Kegiatan')
                            ->required(),

                        Forms\Components\TextInput::make('user_name')
                            ->label('Dosen Pengampu')
                            ->required(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hari')
                    ->label('Hari')
                    ->sortable(),

                Tables\Columns\TextColumn::make('waktu')
                    ->label('Jam Kuliah')
                    ->badge()
                    // Diganti dari 'info' (biru) ke 'gray' supaya bisa di-restyle
                    // gold-soft lewat CSS (.fi-badge-color-gray) tanpa bentrok
                    // dengan badge status lain yang sengaja tetap semantik.
                    ->color('gray'),

                Tables\Columns\TextColumn::make('location.nama_lab')
                    ->label('Ruang Lab')
                    ->fontFamily('mono')
                    ->searchable(),

                Tables\Columns\TextColumn::make('keperluan')
                    ->label('Mata Kuliah')
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('user_name')
                    ->label('Dosen Pengampu')
                    ->wrap()
                    ->searchable()
                    // Kolom paling panjang, disembunyikan default di layar kecil
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('hari', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('hari')
                    ->label('Saring Hari')
                    ->options([
                        'Senin' => 'Senin',
                        'Selasa' => 'Selasa',
                        'Rabu' => 'Rabu',
                        'Kamis' => 'Kamis',
                        'Jumat' => 'Jumat',
                    ]),
                Tables\Filters\SelectFilter::make('location_id')
                    ->label('Saring Lab')
                    ->relationship('location', 'nama_lab'),
            ])
            ->headerActions([
                static::csvExportAction(
                    filename: 'jadwal-penggunaan-lab.csv',
                    headers: ['Hari', 'Jam Kuliah', 'Ruang Lab', 'Mata Kuliah', 'Dosen Pengampu'],
                    query: fn() => static::getModel()::query()->with('location')->orderBy('hari')->get(),
                    rowMapper: fn($r) => [
                        $r->hari,
                        $r->waktu,
                        $r->location?->nama_lab ?? '-',
                        $r->keperluan,
                        $r->user_name,
                    ],
                ),

                // ===== CETAK PDF — SEMUA LAB SEKALIGUS =====
                Tables\Actions\Action::make('cetakPdf')
                    ->label('Cetak PDF')
                    ->icon('heroicon-o-printer')
                    // Diganti dari 'warning' (oranye, beda sendiri) ke 'primary'
                    // supaya otomatis ikut warna Amber/gold tema panel.
                    ->color('primary')
                    ->url(fn() => route('lab-schedule.pdf.all'))
                    ->openUrlInNewTab(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLabSchedules::route('/'),
            'create' => Pages\CreateLabSchedule::route('/create'),
            'edit' => Pages\EditLabSchedule::route('/{record}/edit'),
        ];
    }
}
