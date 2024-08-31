<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DigiSettingResource\Pages;
use App\Filament\Resources\DigiSettingResource\RelationManagers;
use App\Models\Digiflazz;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DigiSettingResource extends Resource
{
    protected static ?string $model = Digiflazz::class;

    protected static ?string $navigationIcon = 'heroicon-o-bolt';

    protected static ?string $label = 'Proxy Configuration';
    protected static ?string $breadcrumb = 'Proxy Configuration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('provider')
                    ->label('Provider')
                    ->required(),
                Forms\Components\TextInput::make('url')
                    ->label('Digiflazz URL')
                    ->url()
                    ->required()
                ->helperText('Masukkan URL Host Digiflazz yang akan digunakan untuk mengirim request'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('url')
                    ->label('Digiflazz URL'),
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
            'index' => Pages\ListDigiSettings::route('/'),
            'create' => Pages\CreateDigiSetting::route('/create'),
            'edit' => Pages\EditDigiSetting::route('/{record}/edit'),
        ];
    }
}
