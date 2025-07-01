<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Catalyst\PrivateCredit\Settings\PrivateCreditSettings as PrivateCreditPluginSettings;

class PrivateCreditSettings extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static string $settings = PrivateCreditPluginSettings::class;

    protected static ?string $title = 'Chart of Accounts';

    protected static ?string $navigationGroup = 'Accounting';

    protected static ?int $navigationSort = 1;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Financial Year Settings')
                    ->description('Configure the start date for your financial year.')
                    ->schema([
                        Forms\Components\DatePicker::make('financial_year_start_date')
                            ->label('Start of Financial Year')
                            ->required()
                            ->date(),
                    ]),
            ])
            ->columns(1);
    }

    protected function getFooterWidgets(): array
    {
        return [
            \Catalyst\PrivateCredit\Filament\Admin\Widgets\FundingAccountsTableWidget::class,
            \Catalyst\PrivateCredit\Filament\Admin\Widgets\ChartOfAccountsTableWidget::class,
        ];
    }
}
