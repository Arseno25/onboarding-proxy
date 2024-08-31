<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceSettingResource\Pages;
use App\Filament\Resources\ServiceSettingResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceSettingResource extends Resource
{
    protected static ?string $model = Service::class;
    protected static ?int $navigationSort = -2;
    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?string $label = 'Service Configuration';
    protected static ?string $breadcrumb = 'Service Configuration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('provider')
                    ->label('Provider')
                    ->required(),
                Forms\Components\TextInput::make('url')
                    ->label('Service API URL')
                    ->url()
                    ->required()
                    ->helperText('Masukkan URL API service yang akan digunakan.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('provider')
                    ->label('Provider'),
                Tables\Columns\TextColumn::make('url')
                    ->label('Service URL'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServiceSettings::route('/'),
            'create' => Pages\CreateServiceSetting::route('/create'),
            'edit' => Pages\EditServiceSetting::route('/{record}/edit'),
        ];
    }
}
