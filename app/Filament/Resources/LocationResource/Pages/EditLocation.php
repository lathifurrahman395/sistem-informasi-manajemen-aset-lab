<?php

namespace App\Filament\Resources\LocationResource\Pages;

use App\Filament\Resources\LocationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLocation extends EditRecord
{
    protected static string $resource = LocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // Otomatis pindah ke tabel setelah klik Save Changes pada ruangan
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
