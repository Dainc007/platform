<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarTypeResource\Pages;
use App\Filament\Resources\CarTypeResource\RelationManagers;
use App\Models\CarType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarTypeResource extends Resource
{
    protected static ?string $model = CarType::class;

    protected static ?string $navigationIcon = 'heroicon-o-truck';

    protected static ?string $navigationLabel = 'Rodzaje Samochodów';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('length')
                    ->required()
                    ->numeric()
                    ->label('Length (cm)'),
                Forms\Components\TextInput::make('width')
                    ->required()
                    ->numeric()
                    ->label('Width (cm)'),
                Forms\Components\TextInput::make('height')
                    ->required()
                    ->numeric()
                    ->label('Height (cm)'),
                Forms\Components\TextInput::make('max_payload')
                    ->required()
                    ->numeric()
                    ->label('Max Payload (kg)'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('length')->sortable(),
                Tables\Columns\TextColumn::make('width')->sortable(),
                Tables\Columns\TextColumn::make('height')->sortable(),
                Tables\Columns\TextColumn::make('max_payload')->sortable(),
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
            'index' => Pages\ListCarTypes::route('/'),
            'create' => Pages\CreateCarType::route('/create'),
            'edit' => Pages\EditCarType::route('/{record}/edit'),
        ];
    }
}
