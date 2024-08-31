<?php

namespace App\Filament\Resources\ServiceSettingResource\Pages;

use App\Filament\Resources\ServiceSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServiceSettings extends ListRecords
{
    protected static string $resource = ServiceSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
