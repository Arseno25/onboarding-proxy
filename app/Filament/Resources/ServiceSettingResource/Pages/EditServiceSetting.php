<?php

namespace App\Filament\Resources\ServiceSettingResource\Pages;

use App\Filament\Resources\ServiceSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditServiceSetting extends EditRecord
{
    protected static string $resource = ServiceSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
