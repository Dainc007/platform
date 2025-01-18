<?php

namespace App\Filament\Resources;

use App\Enums\Currency;
use App\Filament\Resources\PricingResource\Pages;
use App\Filament\Resources\PricingResource\RelationManagers;
use App\Models\Carrier;
use App\Models\Pricing;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PricingResource extends Resource
{
    protected static ?string $model = Pricing::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Cenniki';
    protected static ?string $label = 'Cennik';
    protected static ?string $pluralLabel = 'Cenniki';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('distance_limit')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('price_without_tax')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, callable $get) {
                        $priceWithoutTax = $get('price_without_tax');
                        $taxRate = $get('tax_rate');

                        if ($priceWithoutTax !== null && $taxRate !== null) {
                            $tax = $priceWithoutTax * ($taxRate / 100);
                            $priceWithTax = $priceWithoutTax + $tax;

                            $set('tax', $tax);
                            $set('price_with_tax', $priceWithTax);
                        }
                    }),
                Forms\Components\TextInput::make('tax_rate')
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, callable $get) {
                        $priceWithoutTax = $get('price_without_tax');
                        $taxRate = $get('tax_rate');

                        if ($priceWithoutTax !== null && $taxRate !== null) {
                            $tax = $priceWithoutTax * ($taxRate / 100);
                            $priceWithTax = $priceWithoutTax + $tax;

                            $set('tax', $tax);
                            $set('price_with_tax', $priceWithTax);
                        }
                    }),
                Forms\Components\TextInput::make('price_with_tax')
                    ->required()
                    ->numeric()
                    ->disabled(),
                Forms\Components\TextInput::make('tax')
                    ->required()
                    ->numeric()
                    ->disabled()
                    ->rule('regex:/^\d+(\.\d{1,2})?$/'),
                Forms\Components\Select::make('currency_id')
                    ->relationship('currency', 'name')
                    ->required(),
                Forms\Components\Select::make('priceable_type')
                    ->options([
                        'App\Models\Carrier' => 'Carrier',
                        'App\Models\Supplier' => 'Supplier',
                    ])
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $set('priceable_id', null);
                    }),
                Forms\Components\Select::make('priceable_id')
                    ->required()
                    ->options(function (callable $get) {
                        $type = $get('priceable_type');

                        if ($type === 'App\Models\Carrier') {
                            return Carrier::pluck('name', 'id');
                        }

                        if ($type === 'App\Models\Supplier') {
                            return Supplier::pluck('name', 'id');
                        }

                        return [];
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('priceable.name')->label('Nazwa'),
                TextColumn::make('distance_limit')->sortable()->label('Limit km'),
                TextColumn::make('price_without_tax')->sortable()->label('Netto'),
                TextColumn::make('price_with_tax')->sortable()->label('Brutto'),
                TextColumn::make('tax_rate')->sortable()->label('%'),
                TextColumn::make('tax')->sortable()->label('Podatek'),
                TextColumn::make('currency.code')->sortable()->label('Waluta'),
                TextColumn::make('updated_at')->dateTime()->sortable()->label('Ostatnia Aktualizacja'),
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
            'index' => Pages\ListPricings::route('/'),
            'create' => Pages\CreatePricing::route('/create'),
            'edit' => Pages\EditPricing::route('/{record}/edit'),
        ];
    }
}
