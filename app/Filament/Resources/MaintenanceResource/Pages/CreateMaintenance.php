<?php

namespace App\Filament\Resources\MaintenanceResource\Pages;

use App\Filament\Resources\MaintenanceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMaintenance extends CreateRecord
{
    protected static string $resource = MaintenanceResource::class;

    // ◄ TAMBAHKAN FUNGSI INI AGAR SETELAH CREATE LANGSUNG PINDAH KE TABEL
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
