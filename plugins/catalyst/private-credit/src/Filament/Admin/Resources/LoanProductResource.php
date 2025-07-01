<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources;

use Catalyst\PrivateCredit\Models\ChartOfAccount;
use Catalyst\PrivateCredit\Models\FundingAccount;
use Catalyst\PrivateCredit\Models\LoanProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LoanProductResource extends Resource
{
    protected static ?string $model = LoanProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Loan Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Loan Product Details')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Product Name')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(6),

                                Forms\Components\Textarea::make('description')
                                    ->hint('Optional')
                                    ->maxLength(65535)
                                    ->columnSpan(6),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Active')
                                    ->default(true)
                                    ->columnSpan(6),

                                Forms\Components\TextInput::make('min_principal_amount')
                                    ->label('Minimun Principle Amount')
                                    ->numeric()
                                    ->required()
                                    ->prefix('$')
                                    ->default(0)
                                    ->columnSpan(['default' => 6, 'md' => 3]),

                                Forms\Components\TextInput::make('max_principal_amount')
                                    ->label('Maximun Principle Amount')
                                    ->numeric()
                                    ->required()
                                    ->prefix('$')
                                    ->default(0)
                                    ->columnSpan(['default' => 6, 'md' => 3]),

                                Forms\Components\Select::make('duration_period')
                                    ->label('Duration Period')
                                    ->options([
                                        'days' => 'Days',
                                        'weeks' => 'Weeks',
                                        'months' => 'Months',
                                        'years' => 'Years',
                                    ])
                                    ->live()
                                    ->required()
                                    ->columnSpan(6)
                                    ->default('days'),

                                Forms\Components\Select::make('duration_type')
                                    ->label('Duration Type')
                                    ->options([
                                        'fixed' => 'Fixed',
                                        'interval' => 'Interval',
                                    ])
                                    ->required()
                                    ->live()
                                    ->default('fixed')
                                    ->columnSpan(['default' => 6, 'md' => 2]),

                                Forms\Components\TextInput::make('duration_value')
                                    ->label(fn (Forms\Get $get): string => 'Loan Duration in ' . str($get('duration_period'))->title())
                                    ->numeric()
                                    ->required()
                                    ->default(0)
                                    ->hidden(fn (Forms\Get $get): bool => $get('duration_type') === 'interval')
                                    ->columnSpan(['default' => 6, 'md' => 4]),

                                Forms\Components\TextInput::make('duration_min_value')
                                    ->label(fn (Forms\Get $get): string => 'Minimum Loan Duration in ' . str($get('duration_period'))->title())
                                    ->numeric()
                                    ->required()
                                    ->default(0)
                                    ->columnSpan(['default' => 6, 'md' => 2])
                                    ->hidden(fn (Forms\Get $get): bool => $get('duration_type') === 'fixed'),

                                Forms\Components\TextInput::make('duration_max_value')
                                    ->label(fn (Forms\Get $get): string => 'Maxmum Loan Duration in ' . str($get('duration_period'))->title())
                                    ->numeric()
                                    ->required()
                                    ->default(0)
                                    ->columnSpan(['default' => 6, 'md' => 2])
                                    ->hidden(fn (Forms\Get $get): bool => $get('duration_type') === 'fixed'),

                                Forms\Components\Select::make('interest_rate_type')
                                    ->label('Interest Method')
                                    ->options([
                                        'flat' => 'Flat Interest',
                                        'armotized' => 'Armotized Interest',
                                    ])
                                    ->required()
                                    ->default('flat')
                                    ->columnSpan(['default' => 6, 'md' => 2]),

                                Forms\Components\TextInput::make('interest_rate')
                                    ->label('Interest Rate')
                                    ->numeric()
                                    ->suffix('%')
                                    ->required()
                                    ->default(0)
                                    ->columnSpan(['default' => 6, 'md' => 2]),

                                Forms\Components\Select::make('interest_cycle')
                                    ->label('Interest Cycle')
                                    ->options([
                                        'once' => 'Once',
                                        'per-day' => 'Per Day',
                                        'per-week' => 'Per Week',
                                        'per-month' => 'Per Month',
                                        'per-year' => 'Per Year',
                                    ])
                                    ->required()
                                    ->default('once')
                                    ->columnSpan(['default' => 6, 'md' => 2]),

                                Forms\Components\Select::make('repayment_cycle')
                                    ->label('Repayment Cycle')
                                    ->options([
                                        'once' => 'Once',
                                        'daily' => 'Daily',
                                        'weekly' => 'Weekly',
                                        'bi-weekly' => 'Bi-Weekly',
                                        'monthly' => 'Monthly',
                                        'quarterly' => 'Quarterly',
                                        'semi-annual' => 'Semi-Annual',
                                        'per-year' => 'Per Year',
                                    ])
                                    ->required()
                                    ->default('once')
                                    ->columnSpan(6),
                            ])->columns(6),

                        Forms\Components\Section::make('Fees')
                            ->description('Configure loan fees')
                            ->schema([
                                Forms\Components\Repeater::make('fees')
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                    ->relationship('fees')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->label('Fee Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->live()
                                            ->columnSpanFull(),

                                        Forms\Components\Select::make('type')
                                            ->label('Fee Type')
                                            ->options([
                                                'percentage' => 'Percentage Based',
                                                'fixed' => 'Fixed Amount',
                                            ])
                                            ->default('percentage')
                                            ->required()
                                            ->live(),

                                        Forms\Components\Select::make('calculate_on')
                                            ->label('Calculate On')
                                            ->options([
                                                'principal' => 'Principal Amount',
                                                'interest' => 'Interest Amount',
                                                'principal_and_interest' => 'Principal + Interest Amount',
                                            ])
                                            ->default('principal')
                                            ->required()
                                            ->hidden(fn (Forms\Get $get): bool => $get('type') === 'fixed'),

                                        Forms\Components\TextInput::make('value')
                                            ->label('Value')
                                            ->numeric()
                                            ->required()
                                            ->suffix(fn (Forms\Get $get): string => $get('type') === 'percentage' ? '%' : '$'),

                                        Forms\Components\Toggle::make('is_active_deduct_from_principal')
                                            ->label('Deduct from Principal')
                                            ->helperText('i.e If you give a loan for 2,000 and the fee is 100 the fee would be deducted from 2,000 and remaining amount 1,900 would be given to the borrower.')
                                            ->columnSpanFull(),

                                        Forms\Components\Toggle::make('is_active_spread_across_repayments')
                                            ->label('Spread Across Repayments')
                                            ->helperText('The fee amount will be divided equally and added to each repayment installment.')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(0)
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                    ->addActionLabel('Add Fee')
                                    ->helperText('Add and configure fees applicable to this loan product.'),
                            ]),

                        Forms\Components\Section::make('Late Repayment Penalty')
                            ->description('Configure the penalty for late repayment')
                            ->schema([
                                Forms\Components\Toggle::make('late_penalty_is_active')
                                    ->label('Enable Late Repayment Penalty')
                                    ->live()
                                    ->default(false)
                                    ->columnSpanFull(),

                                Forms\Components\Select::make('late_penalty_type')
                                    ->label('Penalty Type')
                                    ->options([
                                        'percentage' => 'Percentage Based',
                                        'fixed' => 'Fixed Amount',
                                    ])
                                    ->default('percentage')
                                    ->requiredWith('late_penalty_is_active')
                                    ->live()
                                    ->hidden(fn (Forms\Get $get): bool => ! $get('late_penalty_is_active')),

                                Forms\Components\Select::make('late_penalty_calculate_on')
                                    ->label('Calculate Penalty On')
                                    ->options([
                                        'principal' => 'Principal Amount',
                                        'interest' => 'Interest Amount',
                                        'principal_and_interest' => 'Principal + Interest Amount',
                                    ])
                                    ->default('principal')
                                    ->requiredWith('late_penalty_is_active')
                                    ->hidden(fn (Forms\Get $get): bool => ! $get('late_penalty_is_active') || $get('late_penalty_type') === 'fixed'),

                                Forms\Components\TextInput::make('late_penalty_amount')
                                    ->label(fn (Forms\Get $get): string => 'Penalty ' . ['percentage' => 'Percentage', 'fixed' => 'Amount'][$get('late_penalty_type')])
                                    ->numeric()
                                    ->default(0)
                                    ->requiredWith('late_penalty_is_active')
                                    ->hidden(fn (Forms\Get $get): bool => ! $get('late_penalty_is_active')),

                                Forms\Components\TextInput::make('late_penalty_grace_period')
                                    ->label('Grace Period')
                                    ->numeric()
                                    ->default(0)
                                    ->requiredWith('late_penalty_is_active')
                                    ->hidden(fn (Forms\Get $get): bool => ! $get('late_penalty_is_active')),

                                Forms\Components\Select::make('late_penalty_recurring')
                                    ->label('Recurring Penalty')
                                    ->options([
                                        'once' => 'Once',
                                        'daily' => 'Daily',
                                        'weekly' => 'Weekly',
                                        'bi-weekly' => 'Bi-Weekly',
                                        'monthly' => 'Monthly',
                                        'quarterly' => 'Quarterly',
                                        'semi-annual' => 'Semi-Annual',
                                        'per-year' => 'Per Year',
                                    ])
                                    ->default('once')
                                    ->requiredWith('late_penalty_is_active')
                                    ->hidden(fn (Forms\Get $get): bool => ! $get('late_penalty_is_active')),
                            ])->columns(2),

                        Forms\Components\Section::make('Accounts')
                            ->description('Configure journal accounts')
                            ->schema([
                                Forms\Components\Select::make('funding_account_id')
                                    ->label('Funding Account')
                                    ->options(FundingAccount::query()->pluck('name', 'id'))
                                    ->default(1)
                                    ->searchable()
                                    ->required()
                                    ->helperText('Select the source of the Principal Amount to be disbursed.'),
                                // TODO: Change query to also pull the children. Do method in model to simplify.
                                Forms\Components\Select::make('loans_receivable_account_id')
                                    ->label('Loans Receivable Account')
                                    ->options(ChartOfAccount::query()->where('name', 'Loans Receivable')->pluck('name', 'id'))
                                    ->default(1)
                                    ->searchable()
                                    ->required()
                                    ->helperText('The account that will be debited in the general ledger when the loan is disbursed.'),

                                Forms\Components\Select::make('default_interest_income_account_id')
                                    ->label('Default Interest Income Account')
                                    ->options(ChartOfAccount::query()->where('name', 'Interest Income')->pluck('name', 'id'))
                                    ->default(3)
                                    ->searchable()
                                    ->required()
                                    ->helperText('The account that will be credited in the general ledger when interest is received from payments.'),

                                Forms\Components\Select::make('default_fees_income_account_id')
                                    ->label('Default Fees Income Account')
                                    ->options(ChartOfAccount::query()->where('name', 'Fees Income')->pluck('name', 'id'))
                                    ->default(5)
                                    ->searchable()
                                    ->required()
                                    ->helperText('The account that will be credited in the general ledger when fees are received from payments.'),

                                Forms\Components\Select::make('default_penalty_income_account_id')
                                    ->label('Default Penalty Income Account')
                                    ->options(ChartOfAccount::query()->where('name', 'Penalties Income')->pluck('name', 'id'))
                                    ->default(4)
                                    ->searchable()
                                    ->required()
                                    ->helperText('The account that will be credited in the general ledger when penalty is received from payments.'),

                                Forms\Components\Select::make('default_overpayment_account_id')
                                    ->label('Default Overpayment Account')
                                    ->options(ChartOfAccount::query()->where('name', 'Loans Overpayment')->pluck('name', 'id'))
                                    ->default(2)
                                    ->searchable()
                                    ->required()
                                    ->helperText('The account that will be credited in the general ledger when overpayment is received from payments.'),
                            ])->columns(2),
                    ])->columnSpan(['lg' => 6]),
            ])->columns(6);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active')
                    ->sortable(),
                Tables\Columns\TextColumn::make('min_principal_amount')
                    ->money('usd')
                    ->label('Min Principal')
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_principal_amount')
                    ->money('usd')
                    ->label('Max Principal')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_period')
                    ->label('Duration Period')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_type')
                    ->label('Duration Type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('min_duration')
                    ->label('Min Duration')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('max_duration')
                    ->label('Max Duration')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('repayment_cycle')
                    ->label('Repayment Cycle')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('interest_rate_type')
                    ->label('Interest Type')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('interest_rate')
                    ->suffix('%')
                    ->label('Interest Rate')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('interest_cycle')
                    ->label('Interest Cycle')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('late_penalty_is_active')
                    ->boolean()
                    ->label('Late Penalty Active')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('fees_count')
                    ->counts('fees')
                    ->label('Fees')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->boolean()
                    ->trueLabel('Active')
                    ->falseLabel('Inactive')
                    ->placeholder('All'),
                Tables\Filters\SelectFilter::make('duration_period')
                    ->options([
                        'years' => 'Years',
                        'months' => 'Months',
                        'weeks' => 'Weeks',
                        'days' => 'Days',
                    ])
                    ->label('Duration Period'),
                Tables\Filters\SelectFilter::make('repayment_cycle')
                    ->options([
                        'once' => 'Once',
                        'daily' => 'Daily',
                        'weekly' => 'Weekly',
                        'bi-weekly' => 'Bi-Weekly',
                        'monthly' => 'Monthly',
                        'quarterly' => 'Quarterly',
                        'semi-annual' => 'Semi-Annual',
                        'per-year' => 'Per Year',
                    ])
                    ->label('Repayment Cycle'),
                Tables\Filters\SelectFilter::make('interest_rate_type')
                    ->options([
                        'flat' => 'Flat',
                        'armotized' => 'Armotized',
                    ])
                    ->label('Interest Rate Type'),
                Tables\Filters\TernaryFilter::make('late_penalty_is_active')
                    ->label('Late Penalty Active')
                    ->boolean()
                    ->trueLabel('Active')
                    ->falseLabel('Inactive')
                    ->placeholder('All'),
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
            'index' => \Catalyst\PrivateCredit\Filament\Admin\Resources\LoanProductResource\Pages\ListLoanProducts::route('/'),
            'create' => \Catalyst\PrivateCredit\Filament\Admin\Resources\LoanProductResource\Pages\CreateLoanProduct::route('/create'),
            'edit' => \Catalyst\PrivateCredit\Filament\Admin\Resources\LoanProductResource\Pages\EditLoanProduct::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Loan Product';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Loan Products';
    }
}
