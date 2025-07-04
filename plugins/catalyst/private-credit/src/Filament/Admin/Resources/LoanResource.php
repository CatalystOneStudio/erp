<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources;

use App\Models\User;
use Catalyst\PrivateCredit\Models\ChartOfAccount;
use Catalyst\PrivateCredit\Models\FundingAccount;
use Catalyst\PrivateCredit\Models\Loan;
use Catalyst\PrivateCredit\Models\LoanProduct;
use Catalyst\PrivateCredit\Settings\GeneralSettings;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Get;
use Filament\Forms\Set;

class LoanResource extends Resource
{
    protected static ?string $model = Loan::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Loan Management';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make('Add a loan')
                            ->schema([
                                Select::make('loan_product_id')
                                    ->label('Loan Product')
                                    ->options(LoanProduct::query()->pluck('name', 'id'))
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, ?string $state) {
                                        if ($state) {
                                            $loanProduct = LoanProduct::find($state);
                                            if ($loanProduct) {
                                                $set('principal_amount', $loanProduct->min_principal_amount);
                                                $set('loan_duration', $loanProduct->duration_value);
                                                $set('duration_period', $loanProduct->duration_period);
                                                $set('interest_method', $loanProduct->interest_rate_type);
                                                $set('interest_rate', $loanProduct->interest_rate);
                                                $set('interest_cycle', $loanProduct->interest_cycle);
                                                $set('repayment_cycle', $loanProduct->repayment_cycle);
                                                $set('late_penalty_is_active', $loanProduct->late_penalty_is_active);
                                                $set('late_penalty_type', $loanProduct->late_penalty_type);
                                                $set('late_penalty_calculate_on', $loanProduct->late_penalty_calculate_on);
                                                $set('late_penalty_amount', $loanProduct->late_penalty_amount);
                                                $set('late_penalty_grace_period', $loanProduct->late_penalty_grace_period);
                                                $set('late_penalty_recurring', $loanProduct->late_penalty_recurring);
                                                $set('funding_account_id', $loanProduct->funding_account_id);
                                                $set('loans_receivable_account_id', $loanProduct->loans_receivable_account_id);
                                                $set('default_interest_income_account_id', $loanProduct->default_interest_income_account_id);
                                                $set('default_fees_income_account_id', $loanProduct->default_fees_income_account_id);
                                                $set('default_penalty_income_account_id', $loanProduct->default_penalty_income_account_id);
                                                $set('default_overpayment_account_id', $loanProduct->default_overpayment_account_id);
                                            }
                                        }
                                    })
                                    ->columnSpan(6),

                                Select::make('loan_status')
                                    ->label('Loan Status')
                                    ->options([
                                        'requested' => 'Requested',
                                        'processing' => 'Processing',
                                        'active' => 'Active',
                                        'defaulted' => 'Defaulted',
                                        'denied' => 'Denied'
                                    ])
                                    ->default('processing')
                                    ->required()
                                    ->columnSpan(6),

                                Select::make('borrower_id')
                                    ->label('Borrower or Group')
                                    ->options(User::query()->pluck('name', 'id')) // Assuming User model for borrowers
                                    ->searchable()
                                    ->required()
                                    ->columnSpan(6),

                                TextInput::make('principal_amount')
                                    ->label('Principal Amount')
                                    ->default(0)
                                    ->mask(\Filament\Support\RawJs::make('$money($input)'))
                                    ->stripCharacters(',')
                                    ->numeric()
                                    ->required()
                                    ->prefix('$')
                                    ->suffix(fn (GeneralSettings $settings): string => $settings->currency)
                                    ->columnSpan(['default' => 6, 'md' => 3]),

                                DatePicker::make('loan_release_date')
                                    ->label('Loan Release Date')
                                    ->required()
                                    ->default(now())
                                    ->columnSpan(['default' => 6, 'md' => 3]),

                                TextInput::make('loan_duration')
                                    ->label('Loan Duration')
                                    ->default(1)
                                    ->numeric()
                                    ->required()
                                    ->columnSpan(['default' => 6, 'md' => 3]),

                                Select::make('duration_period')
                                    ->label('Duration Period')
                                    ->options([
                                        'days' => 'Days',
                                        'weeks' => 'Weeks',
                                        'months' => 'Months',
                                        'years' => 'Years',
                                    ])
                                    ->default('months')
                                    ->required()
                                    ->columnSpan(['default' => 6, 'md' => 3]),

                                Select::make('interest_method')
                                    ->label('Interest Method')
                                    ->options([
                                        'flat' => 'Flat Interest',
                                        'armotized' => 'Armotized Interest',
                                    ])
                                    ->default('flat')
                                    ->required()
                                    ->columnSpan(['default' => 6, 'md' => 2]),

                                TextInput::make('interest_rate')
                                    ->label('Interest Rate')
                                    ->default(0)
                                    ->numeric()
                                    ->suffix('%')
                                    ->required()
                                    ->columnSpan(['default' => 6, 'md' => 2]),

                                Select::make('interest_cycle')
                                    ->label('Interest Cycle')
                                    ->options([
                                        'once' => 'Once',
                                        'per-day' => 'Per Day',
                                        'per-week' => 'Per Week',
                                        'per-month' => 'Per Month',
                                        'per-year' => 'Per Year',
                                    ])
                                    ->default('once')
                                    ->required()
                                    ->columnSpan(['default' => 6, 'md' => 2]),

                                Select::make('repayment_cycle')
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
                                    ->default('once')
                                    ->required()
                                    ->columnSpan(6),
                                Actions::make([
                                    Action::make('viewRepaymentSchedule')
                                        ->label('View Repayment Schedule')
                                        ->modalContent(fn (Get $get) => view('private-credit::filament.widgets.repayment-schedule', [
                                            'principal_amount' => $get('principal_amount'),
                                            'interest_rate' => $get('interest_rate'),
                                            'loan_duration' => $get('loan_duration'),
                                            'duration_period' => $get('duration_period'),
                                            'repayment_cycle' => $get('repayment_cycle'),
                                            'loan_release_date' => $get('loan_release_date'),
                                        ]))
                                        ->modalSubmitAction(false)
                                        ->slideOver(),
                                ])
                                ->alignCenter()
                                ->columnSpan(6)
                            ])->columns(6),

                        Section::make('Custom Repayment Schedule')
                            ->schema([
                                Toggle::make('custom_repayment_schedule_enabled')
                                    ->label('Configure custom days when repayments can be made')
                                    ->live()
                                    ->columnSpan(6),
                                ToggleButtons::make('custom_repayment_days')
                                    ->multiple()
                                    ->options([
                                        'monday' => 'Monday',
                                        'tuesday' => 'Tuesday',
                                        'wednesday' => 'Wednesday',
                                        'thursday' => 'Thursday',
                                        'friday' => 'Friday',
                                        'saturday' => 'Saturday',
                                        'sunday' => 'Sunday'
                                    ])
                                    ->default([ 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])
                                    ->inline()
                                    ->columnSpan(6)
                                    ->hidden(fn (Get $get): bool => ! $get('custom_repayment_schedule_enabled'))
                            ]),

                        Section::make('Fees')
                            ->description('Configure loan fees')
                            ->schema([
                                Repeater::make('fees')
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                    ->relationship('fees')
                                    ->schema([
                                        TextInput::make('name')
                                            ->label('Fee Name')
                                            ->required()
                                            ->maxLength(255)
                                            ->live()
                                            ->columnSpanFull(),

                                        Select::make('type')
                                            ->label('Fee Type')
                                            ->options([
                                                'percentage' => 'Percentage Based',
                                                'fixed' => 'Fixed Amount',
                                            ])
                                            ->default('percentage')
                                            ->required()
                                            ->live(),

                                        Select::make('calculate_on')
                                            ->label('Calculate On')
                                            ->options([
                                                'principal' => 'Principal Amount',
                                                'interest' => 'Interest Amount',
                                                'principal_and_interest' => 'Principal + Interest Amount',
                                            ])
                                            ->default('principal')
                                            ->required()
                                            ->hidden(fn (Get $get): bool => $get('type') === 'fixed'),

                                        TextInput::make('value')
                                            ->label('Value')
                                            ->numeric()
                                            ->required()
                                            ->suffix(fn (Get $get): string => $get('type') === 'percentage' ? '%' : '$'),

                                        Toggle::make('is_active_deduct_from_principal')
                                            ->label('Deduct from Principal')
                                            ->helperText('i.e If you give a loan for 2,000 and the fee is 100 the fee would be deducted from 2,000 and remaining amount 1,900 would be given to the borrower.')
                                            ->columnSpanFull(),

                                        Toggle::make('is_active_spread_across_repayments')
                                            ->label('Spread Across Repayments')
                                            ->helperText('The fee amount will be divided equally and added to each repayment installment.')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(0)
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                    ->addActionLabel('Add Fee')
                                    ->helperText('Add and configure fees applicable to this loan.'),
                            ]),

                        Section::make('Late Repayment Penalty')
                            ->description('Configure the penalty for late repayment')
                            ->schema([
                                Toggle::make('late_penalty_is_active')
                                    ->label('Enable Late Repayment Penalty')
                                    ->live()
                                    ->default(false)
                                    ->columnSpanFull(),

                                Select::make('late_penalty_type')
                                    ->label('Penalty Type')
                                    ->options([
                                        'percentage' => 'Percentage Based',
                                        'fixed' => 'Fixed Amount',
                                    ])
                                    ->default('percentage')
                                    ->requiredWith('late_penalty_is_active')
                                    ->live()
                                    ->hidden(fn (Get $get): bool => ! $get('late_penalty_is_active')),

                                Select::make('late_penalty_calculate_on')
                                    ->label('Calculate Penalty On')
                                    ->options([
                                        'principal' => 'Principal Amount',
                                        'interest' => 'Interest Amount',
                                        'principal_and_interest' => 'Principal + Interest Amount',
                                    ])
                                    ->default('principal')
                                    ->requiredWith('late_penalty_is_active')
                                    ->hidden(fn (Get $get): bool => ! $get('late_penalty_is_active') || $get('late_penalty_type') === 'fixed'),

                                TextInput::make('late_penalty_amount')
                                    ->label(fn (Get $get): string => 'Penalty ' . ['percentage' => 'Percentage', 'fixed' => 'Amount'][$get('late_penalty_type')])
                                    ->numeric()
                                    ->default(0)
                                    ->requiredWith('late_penalty_is_active')
                                    ->hidden(fn (Get $get): bool => ! $get('late_penalty_is_active')),

                                TextInput::make('late_penalty_grace_period')
                                    ->label('Grace Period')
                                    ->numeric()
                                    ->default(0)
                                    ->requiredWith('late_penalty_is_active')
                                    ->hidden(fn (Get $get): bool => ! $get('late_penalty_is_active')),

                                Select::make('late_penalty_recurring')
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
                                    ->hidden(fn (Get $get): bool => ! $get('late_penalty_is_active')),
                            ])->columns(2),

                        Section::make('Collateral')
                            ->description('Details of the collateral')
                            ->schema([
                                TextInput::make('collateral_name')
                                    ->label('Name')
                                    ->maxLength(255),

                                Textarea::make('collateral_description')
                                    ->label('Description')
                                    ->hint('Give details about the collateral')
                                    ->maxLength(65535),

                                Textarea::make('collateral_defects')
                                    ->label('Defects')
                                    ->hint('Describe all the defects that the collateral might have')
                                    ->maxLength(65535),

                                FileUpload::make('collateral_files')
                                    ->label('Files/Images')
                                    ->multiple()
                                    ->directory('collateral-attachments')
                                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                                    ->enableDownload()
                                    ->enableOpen(),
                            ])->columns(1),

                        Section::make('Accounts')
                            ->description('Configure journal accounts')
                            ->schema([
                                Select::make('funding_account_id')
                                    ->label('Funding Account')
                                    ->options(FundingAccount::query()->pluck('name', 'id'))
                                    ->default(1)
                                    ->searchable()
                                    ->required()
                                    ->helperText('Select the source of the Principal Amount to be disbursed.'),
                                // TODO: Change query to also pull the children. Do method in model to simplify.
                                Select::make('loans_receivable_account_id')
                                    ->label('Loans Receivable Account')
                                    ->options(ChartOfAccount::query()->where('name', 'Loans Receivable')->pluck('name', 'id'))
                                    ->default(1)
                                    ->searchable()
                                    ->required()
                                    ->helperText('The account that will be debited in the general ledger when the loan is disbursed.'),

                                Select::make('default_interest_income_account_id')
                                    ->label('Default Interest Income Account')
                                    ->options(ChartOfAccount::query()->where('name', 'Interest Income')->pluck('name', 'id'))
                                    ->default(3)
                                    ->searchable()
                                    ->required()
                                    ->helperText('The account that will be credited in the general ledger when interest is received from payments.'),

                                Select::make('default_fees_income_account_id')
                                    ->label('Default Fees Income Account')
                                    ->options(ChartOfAccount::query()->where('name', 'Fees Income')->pluck('name', 'id'))
                                    ->default(5)
                                    ->searchable()
                                    ->required()
                                    ->helperText('The account that will be credited in the general ledger when fees are received from payments.'),

                                Select::make('default_penalty_income_account_id')
                                    ->label('Default Penalty Income Account')
                                    ->options(ChartOfAccount::query()->where('name', 'Penalties Income')->pluck('name', 'id'))
                                    ->default(4)
                                    ->searchable()
                                    ->required()
                                    ->helperText('The account that will be credited in the general ledger when penalty is received from payments.'),

                                Select::make('default_overpayment_account_id')
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
                Tables\Columns\TextColumn::make('borrower.name')
                    ->label('Borrower')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('loan_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'requested' => 'gray',
                        'processing' => 'info',
                        'active' => 'success',
                        'defaulted' => 'success',
                        'completed' => 'success',
                        'denied' => 'danger',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('principal_amount')
                    ->money('usd')
                    ->label('Principal')
                    ->sortable(),
                Tables\Columns\TextColumn::make('loan_release_date')
                    ->date()
                    ->label('Release Date')
                    ->sortable(),
                Tables\Columns\TextColumn::make('loan_duration')
                    ->label('Duration')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_period')
                    ->label('Period')
                    ->sortable(),
                Tables\Columns\TextColumn::make('interest_rate')
                    ->suffix('%')
                    ->label('Interest Rate')
                    ->sortable(),
                Tables\Columns\TextColumn::make('repayment_cycle')
                    ->label('Repayment Cycle')
                    ->sortable(),
                Tables\Columns\TextColumn::make('collateral_name')
                    ->label('Collateral')
                    ->searchable()
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
                Tables\Filters\SelectFilter::make('loan_status')
                    ->options([
                        'requested' => 'Requested',
                        'processing' => 'Processing',
                        'active' => 'Active',
                        'defaulted' => 'Defaulted',
                        'denied' => 'Denied'
                    ])
                    ->label('Loan Status'),
                Tables\Filters\SelectFilter::make('borrower_id')
                    ->relationship('borrower', 'name')
                    ->label('Borrower'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => \Catalyst\PrivateCredit\Filament\Admin\Resources\LoanResource\Pages\ListLoans::route('/'),
            'view' => \Catalyst\PrivateCredit\Filament\Admin\Resources\LoanResource\Pages\ViewLoan::route('/{record}/view'),
            'create' => \Catalyst\PrivateCredit\Filament\Admin\Resources\LoanResource\Pages\CreateLoan::route('/create'),
            'edit' => \Catalyst\PrivateCredit\Filament\Admin\Resources\LoanResource\Pages\EditLoan::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Loan';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Loans';
    }
}
