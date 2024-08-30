<?php

namespace App\Filament\Resources\DigiSettingResource\Pages;

use App\Filament\Resources\DigiSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDigiSettings extends ListRecords
{
    protected static string $resource = DigiSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
