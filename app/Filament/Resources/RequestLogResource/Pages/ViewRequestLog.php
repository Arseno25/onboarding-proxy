<?php

namespace App\Filament\Resources\RequestLogResource\Pages;

use App\Filament\Resources\RequestLogResource;
use Filament\Actions;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\ViewRecord;

class ViewRequestLog extends ViewRecord
{
    protected static string $resource = RequestLogResource::class;


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('endpoint')
                    ->label('Endpoint')
                    ->disabled(),
                KeyValue::make('data'),
                KeyValue::make('meta'),
            ])
            ->columns(1);
    }
}
