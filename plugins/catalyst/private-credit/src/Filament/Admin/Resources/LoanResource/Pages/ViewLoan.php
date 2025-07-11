<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources\LoanResource\Pages;

use Catalyst\PrivateCredit\Filament\Admin\Resources\LoanResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Split;
use Filament\Support\Enums\FontWeight;

class ViewLoan extends ViewRecord
{
    protected static string $resource = LoanResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Tabs::make('Tabs')
                    ->contained(false)
                    ->columnSpanFull()
                    ->tabs([
                        Tabs\Tab::make('Details')
                            ->icon('heroicon-o-identification')
                            ->schema([
                                Split::make([
                                    Section::make([
                                        Fieldset::make('Loan Information')
                                            ->schema([
                                                TextEntry::make('id')
                                                    ->label('Loan ID'),
                                                TextEntry::make('loan_duration')
                                                    ->label('Duration'),
                                            ]),
                                        Fieldset::make('Amount Details')
                                            ->schema([
                                                TextEntry::make('principal_amount')->money('USD')
                                                    ->color('info')
                                                    ->weight(FontWeight::Bold)
                                                    ->size(TextEntry\TextEntrySize::Large),
                                                TextEntry::make('interest_rate')->suffix('%'),
                                                TextEntry::make('interest_method'),
                                                TextEntry::make('duration_period')->label('Period'),
                                                TextEntry::make('repayment_cycle'),
                                                TextEntry::make('loan_release_date')->date(),
                                            ])
                                    ]),
                                    Section::make([
                                        Fieldset::make('Loan Details')
                                            ->schema([
                                                TextEntry::make('principal_amount')->money('USD'),
                                                TextEntry::make('interest_rate')->suffix('%'),
                                                TextEntry::make('interest_method'),
                                                TextEntry::make('loan_duration')->label('Duration'),
                                            ])
                                    ])
                                ])->from('md')
                            ]),

                        Tabs\Tab::make('Fees & Penalties')
                            ->icon('heroicon-o-receipt-percent')
                            ->schema([
                                // Will add repeater for fees here later
                                Section::make('Late Repayment Penalty')
                                    ->schema([
                                        TextEntry::make('late_penalty_is_active')->label('Penalty Active?')->formatStateUsing(fn ($state) => $state ? 'Yes' : 'No'),
                                        TextEntry::make('late_penalty_type')->label('Penalty Type'),
                                        TextEntry::make('late_penalty_calculate_on')->label('Calculate On'),
                                        TextEntry::make('late_penalty_amount')->label('Amount'),
                                        TextEntry::make('late_penalty_grace_period')->label('Grace Period (days)'),
                                        TextEntry::make('late_penalty_recurring')->label('Recurring'),
                                    ])->columns(2),
                            ]),

                        Tabs\Tab::make('Discounts')
                            ->icon('heroicon-o-ticket')
                            ->schema([
                                // Placeholder for discounts
                            ]),

                        Tabs\Tab::make('Borrower')
                            ->icon('heroicon-o-user')
                            ->schema([
                                Section::make('Borrower Details')
                                    ->schema([
                                        TextEntry::make('borrower.name'),
                                        TextEntry::make('borrower.email'),
                                        // Add more borrower fields here
                                    ])->columns(2),
                            ]),

                        Tabs\Tab::make('Collateral')
                            ->icon('heroicon-o-shield-check')
                            ->schema([
                                Section::make('Collateral Information')
                                    ->schema([
                                        TextEntry::make('collateral_name'),
                                        TextEntry::make('collateral_description'),
                                        TextEntry::make('collateral_defects'),
                                        // Add file viewer for collateral_files
                                    ])->columns(1),
                            ]),

                        Tabs\Tab::make('Admin')
                            ->icon('heroicon-o-cog-6-tooth')
                            ->schema([
                                Section::make('Danger Zone')
                                    ->schema([
                                        Actions::make([
                                            Action::make('approve')
                                                ->label('Approve Loan Request')
                                                ->color('success')
                                                ->requiresConfirmation()
                                                ->action(function ($record) {
                                                    $record->update(['loan_status' => 'active']);
                                                }),
                                            Action::make('reject')
                                                ->label('Reject Loan Request')
                                                ->color('danger')
                                                ->requiresConfirmation()
                                                ->action(function ($record) {
                                                    $record->update(['loan_status' => 'denied']);
                                                }),
                                        ])->fullWidth(),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
