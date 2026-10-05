<?php

namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAsset extends CreateRecord
{
    protected static string $resource = AssetResource::class;

    // Otomatis pindah ke tabel setelah sukses tambah data
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}