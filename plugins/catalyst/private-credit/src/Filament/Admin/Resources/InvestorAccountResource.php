<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources;

use Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorAccountResource\Pages;
use Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorAccountResource\RelationManagers;
use Catalyst\PrivateCredit\Models\InvestorAccount;
use Catalyst\PrivateCredit\Models\Investor;
use Catalyst\PrivateCredit\Models\InvestorProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class InvestorAccountResource extends Resource
{
    protected static ?string $model = InvestorAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Investor Management';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('investor_id')
                    ->label('Investor')
                    ->relationship('investor', 'first_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('investor_product_id')
                    ->label('Investor Product')
                    ->relationship('investorProduct', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('account_code')
                    ->label('Investor Account Code')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('investor.name')
                    ->label('Investor')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('investorProduct.name')
                    ->label('Investor Product')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('account_code')
                    ->label('Account Code')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('balance')
                    ->label('Balance')
                    ->money('TTD')
                    ->sortable(),
                TextColumn::make('last_transaction_date')
                    ->label('Last Transaction')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListInvestorAccounts::route('/'),
            'create' => Pages\CreateInvestorAccount::route('/create'),
            'view' => Pages\ViewInvestorAccount::route('/{record}')
        ];
    }
}
