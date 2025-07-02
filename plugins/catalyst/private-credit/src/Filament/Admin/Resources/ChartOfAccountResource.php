<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources;

use Catalyst\PrivateCredit\Models\ChartOfAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChartOfAccountResource extends Resource
{
    protected static ?string $model = ChartOfAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationGroup = 'Accounting';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Chart of Account Details')
                    ->description('Configure the details of the chart of account.')
                    ->schema([
                        Forms\Components\Select::make('parent_id')
                            ->relationship('parent', 'name')
                            ->label('Parent Account')
                            ->nullable()
                            ->hint('Optional'),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->hint('Optional'),
                        Forms\Components\Select::make('account_type')
                            ->options([
                                'asset' => 'Asset',
                                'liability' => 'Liability',
                                'equity' => 'Equity',
                                'income' => 'Income',
                                'expense' => 'Expense',
                            ])
                            ->default('asset')
                            ->required(),
                        Forms\Components\Select::make('cashflow_type')
                            ->options([
                                'none' => 'None',
                                'operating_activities' => 'Operating Activities',
                                'investing_activities' => 'Investing Activities',
                                'financing_activities' => 'Financing Activities',
                            ])
                            ->default('none')
                            ->required(),
                        Forms\Components\Toggle::make('is_enabled')
                            ->required()
                            ->default(true),
                    ]),
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
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('account_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cashflow_type')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_enabled')
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
            'index' => \Catalyst\PrivateCredit\Filament\Admin\Resources\ChartOfAccountResource\Pages\ListChartOfAccounts::route('/'),
            'create' => \Catalyst\PrivateCredit\Filament\Admin\Resources\ChartOfAccountResource\Pages\CreateChartOfAccount::route('/create'),
            'edit' => \Catalyst\PrivateCredit\Filament\Admin\Resources\ChartOfAccountResource\Pages\EditChartOfAccount::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [
            'account_code',
            'account_name',
            'account_type',
            'cashflow_type',
        ];
    }
}
