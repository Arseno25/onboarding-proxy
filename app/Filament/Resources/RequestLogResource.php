<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestLogResource\Pages;
use App\Filament\Resources\RequestLogResource\RelationManagers;
use App\Models\RequestLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Tabs;

class RequestLogResource extends Resource
{
    protected static ?string $model = RequestLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('endpoint')
                    ->label('Endpoint'),
                Tables\Columns\TextColumn::make('data')
                    ->limit(20)
                    ->label('Data'),
                Tables\Columns\TextColumn::make('meta')
                    ->limit(20)
                    ->label('Meta'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListRequestLogs::route('/'),
            'create' => Pages\CreateRequestLog::route('/create'),
//            'edit' => Pages\EditRequestLog::route('/{record}/edit'),
            'view' => Pages\ViewRequestLog::route('/{record}'),
        ];
    }
}
