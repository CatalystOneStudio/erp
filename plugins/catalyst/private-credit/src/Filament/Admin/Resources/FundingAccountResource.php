<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources;

use Catalyst\PrivateCredit\Models\FundingAccount;
use Catalyst\PrivateCredit\Models\Bank;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Webkul\Support\Models\Country;
use Webkul\Support\Models\Currency;

class FundingAccountResource extends Resource
{
    protected static ?string $model = FundingAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-wallet';

    protected static ?string $navigationGroup = 'Accounting';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Funding Account Details')
                    ->schema([
                        Forms\Components\Select::make('parent_id')
                            ->relationship('parent', 'name')
                            ->label('Parent Account')
                            ->hint('Optional')
                            ->nullable(),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('code')
                            ->maxLength(255)
                            ->hint('Optional'),
                        Forms\Components\Select::make('currency')
                            ->options(Currency::all()->pluck('name', 'name'))
                            ->searchable()
                            ->default('TTD')
                            ->required(),
                        Forms\Components\Select::make('account_type')
                            ->options([
                                'Cash' => 'Cash',
                                'Bank' => 'Bank',
                            ])
                            ->default('Bank')
                            ->live()
                            ->required(),
                        Forms\Components\Select::make('bank_id')
                            ->relationship('bank', 'name')
                            ->label('Bank')
                            ->nullable()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('swift_code')
                                    ->hint('Optional')
                                    ->maxLength(11),
                                Forms\Components\TextInput::make('routing_number')
                                    ->hint('Optional')
                                    ->maxLength(20),
                                Forms\Components\Select::make('country')
                                    ->options(Country::all()->pluck('name', 'name'))
                                    ->searchable()
                                    ->required(),
                            ])
                            ->hidden(fn (Forms\Get $get) => $get('account_type') !== 'Bank'),
                        Forms\Components\TextInput::make('bank_account_number')
                            ->maxLength(255)
                            ->hint('Optional')
                            ->hidden(fn (Forms\Get $get) => $get('account_type') !== 'Bank'),
                        Forms\Components\TextInput::make('bank_account_holder_name')
                            ->maxLength(255)
                            ->hint('Optional')
                            ->hidden(fn (Forms\Get $get) => $get('account_type') !== 'Bank'),
                        Forms\Components\Toggle::make('status')
                            ->required()
                            ->default(true),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Parent Account')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('currency')
                    ->searchable(),
                Tables\Columns\TextColumn::make('account_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank.name')
                    ->label('Bank')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('bank_account_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bank_account_holder_name')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => \Catalyst\PrivateCredit\Filament\Admin\Resources\FundingAccountResource\Pages\ListFundingAccounts::route('/'),
            'create' => \Catalyst\PrivateCredit\Filament\Admin\Resources\FundingAccountResource\Pages\CreateFundingAccount::route('/create'),
            'edit' => \Catalyst\PrivateCredit\Filament\Admin\Resources\FundingAccountResource\Pages\EditFundingAccount::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'name',
            'code',
            'currency',
            'account_type',
            'bank_account_number',
            'bank_account_holder_name',
        ];
    }
}
