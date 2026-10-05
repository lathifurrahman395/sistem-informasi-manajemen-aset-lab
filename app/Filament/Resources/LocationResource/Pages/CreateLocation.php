<?php

namespace App\Filament\Resources\LocationResource\Pages;

use App\Filament\Resources\LocationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLocation extends CreateRecord
{
    protected static string $resource = LocationResource::class;

    // Otomatis pindah ke tabel setelah sukses tambah data ruangan
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}