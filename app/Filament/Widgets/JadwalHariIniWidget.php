<?php

namespace App\Filament\Widgets;

use App\Models\LabSchedule;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class JadwalHariIniWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 2;

    public function getHeading(): ?string
    {
        return 'Jadwal Lab Hari Ini — ' . $this->hariIni();
    }

    protected function hariIni(): string
    {
        $map = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
        ];
        return $map[Carbon::now()->format('l')];
    }

    public function table(Table $table): Table
    {
        $kolomLab = Schema::hasColumn('locations', 'nama_laboratorium') ? 'nama_laboratorium' : 'nama_lab';
        $hariIni = $this->hariIni();

        return $table
            ->query(
                LabSchedule::query()
                    ->where('hari', $hariIni)
                    ->with('location')
                    ->orderBy('waktu')
            )
            ->columns([
                Tables\Columns\TextColumn::make('waktu')
                    ->label('Jam')
                    ->badge()
                    ->color('warning'),
                Tables\Columns\TextColumn::make("location.{$kolomLab}")
                    ->label('Ruang Lab')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('keperluan')
                    ->label('Mata Kuliah / Kegiatan')
                    ->wrap(),
                Tables\Columns\TextColumn::make('user_name')
                    ->label('Dosen Pengampu')
                    ->wrap()
                    ->limit(40),
            ])
            ->paginated(false)
            ->emptyStateHeading('Tidak ada jadwal hari ini')
            ->emptyStateDescription('Semua lab kosong, tidak ada kegiatan terjadwal.')
            ->emptyStateIcon('heroicon-o-calendar-days');
    }
}
