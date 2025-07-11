<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorAccountResource\Pages;

use Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Support\Enums\FontWeight;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid as FormsGrid;
use Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorResource;
use Filament\Infolists\Components\Actions as InfolistsActions;

class ViewInvestorAccount extends ViewRecord
{
    protected static string $resource = InvestorAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Tabs::make('Investor Account Details')
                    ->contained(false)
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Account Details')
                            ->icon('heroicon-m-wallet')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Group::make()
                                            ->schema([
                                                Section::make('Account Balance')
                                                    ->schema([
                                                        TextEntry::make('balance')
                                                            ->label('')
                                                            ->money('TTD')
                                                            ->size(TextEntry\TextEntrySize::Large)
                                                            ->weight(FontWeight::Bold),
                                                    ]),
                                            ]),
                                        Group::make()
                                            ->schema([
                                                Section::make('Account Information')
                                                    ->schema([
                                                        TextEntry::make('investorProduct.name')
                                                            ->label('Product'),
                                                        TextEntry::make('last_transaction_date')
                                                            ->label('Last Transaction')
                                                            ->date(),
                                                        TextEntry::make('interest_type')
                                                            ->label('Interest Type'),
                                                        TextEntry::make('interest_rate')
                                                            ->label('Interest Rate')
                                                            ->suffix('% Monthly'),
                                                    ]),
                                            ]),
                                    ]),
                                Section::make('Financial Summary')
                                    ->schema([
                                        TextEntry::make('total_deposits')
                                            ->label('Total Deposits')
                                            ->money('TTD')
                                            ->icon('heroicon-m-arrow-down-on-square'),
                                        TextEntry::make('total_withdrawals')
                                            ->label('Total Withdrawals')
                                            ->money('TTD')
                                            ->icon('heroicon-m-arrow-up-on-square'),
                                        TextEntry::make('total_bank_fees')
                                            ->label('Total Bank Fees')
                                            ->money('TTD')
                                            ->icon('heroicon-m-banknotes'),
                                        TextEntry::make('total_interest_earned')
                                            ->label('Total Interest Earned')
                                            ->money('TTD')
                                            ->icon('heroicon-m-currency-dollar'),
                                    ]),
                            ]),
                        Tab::make('Transactions')
                            ->icon('heroicon-m-arrows-right-left')
                            ->schema([
                                // Placeholder for transactions table
                                // This will likely be a Filament Table component
                                // For now, a simple text entry
                                TextEntry::make('transactions_placeholder')
                                    ->label('Transactions')
                                    ->default('Transactions will be displayed here.'),
                                InfolistsActions::make([
                                    Action::make('add_transaction')
                                        ->label('Add Transaction')
                                        ->button()
                                        ->icon('heroicon-o-plus')
                                        ->form([
                                            Section::make('Add New Transaction')
                                                ->schema([
                                                    FormsGrid::make(2)
                                                        ->schema([
                                                            DatePicker::make('posting_date')
                                                                ->label('Posting Date')
                                                                ->required(),
                                                            TextInput::make('description')
                                                                ->label('Description')
                                                                ->required()
                                                                ->maxLength(255),
                                                            TextInput::make('total_debit')
                                                                ->label('Total Debit')
                                                                ->numeric()
                                                                ->required(),
                                                        ]),
                                                ]),
                                        ])
                                        ->action(function (array $data) {
                                            // Logic to save transaction
                                        }),
                                ])
                            ]),
                        Tab::make('Investor Details')
                            ->icon('heroicon-m-user')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        Group::make()
                                            ->schema([
                                                TextEntry::make('investor.name')
                                                    ->label('Name'),
                                                TextEntry::make('investor.email')
                                                    ->label('Email'),
                                                TextEntry::make('investor.phone_number')
                                                    ->label('Primary Phone Number'),
                                            ]),
                                        Group::make()
                                            ->schema([
                                                ImageEntry::make('investor.avatar_url')
                                                    ->label('')
                                                    ->circular(),
                                            ]),
                                    ]),
                                InfolistsActions::make([
                                    Action::make('view_investor')
                                        ->label('View Investor')
                                        ->button()
                                        ->url(fn ($record) => InvestorResource::getUrl('view', ['record' => $record->investor_id])),
                                    Action::make('print_investor_statement')
                                        ->label('Print Investor Statement')
                                        ->button()
                                        ->action(function () {
                                            // Logic to generate and print statement
                                        }),
                                ])
                            ]),
                        Tab::make('Dangerzone')
                            ->icon('heroicon-m-exclamation-triangle')
                            ->schema([
                                Section::make('Danger Zone')
                                    ->schema([
                                        TextEntry::make('delete_account_info')
                                            ->label('Delete Investor Account')
                                            ->default('Delete this investor Account.'),
                                        InfolistsActions::make([
                                            Action::make('delete_investor_account')
                                                ->label('Delete')
                                                ->color('danger')
                                                ->requiresConfirmation()
                                                ->action(fn ($record) => $record->delete()),
                                        ])
                                    ]),
                            ]),
                    ])
            ]);
    }
}
