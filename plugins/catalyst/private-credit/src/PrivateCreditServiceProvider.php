<?php

namespace Catalyst\PrivateCredit;

use Catalyst\PrivateCredit\Livewire\RepaymentSchedule;
use Catalyst\PrivateCredit\Models\Investor;
use Catalyst\PrivateCredit\Policies\InvestorPolicy;
use Livewire\Livewire;
use Webkul\Support\Console\Commands\InstallCommand;
use Webkul\Support\Console\Commands\UninstallCommand;
use Webkul\Support\Package;
use Webkul\Support\PackageServiceProvider;
use Illuminate\Support\Facades\Gate;

class PrivateCreditServiceProvider extends PackageServiceProvider
{
    public static string $name = 'private-credit';

    public static string $viewNamespace = 'private-credit';

    public function configureCustomPackage(Package $package): void
    {
        $package->name(static::$name)
        ->hasViews()
        ->hasTranslations()
        ->hasMigrations([
            '2025_06_29_003654_create_private_credit_loan_products_table',
            '2025_06_29_003705_create_private_credit_fees_table',
            '2025_06_29_195328_create_private_credit_banks_table',
            '2025_06_29_195408_create_private_credit_funding_accounts_table',
            '2025_06_29_195436_create_private_credit_chart_of_accounts_table',
            '2025_07_02_054302_create_timezones_table',
            '2025_07_02_164433_create_private_credit_loans_table',
            '2025_07_04_162233_create_private_credit_discounts_table',
            '2025_07_06_020722_create_private_credit_investors_table',
            '2025_07_06_153036_create_private_credit_investor_products_table',
            '2025_07_07_162408_create_private_credit_investor_accounts_table',
        ])
        ->runsMigrations()
        ->hasSettings([
            '2025_06_30_171306_create_private_credit_settings',
            '2025_07_02_042957_create_private_credit_general_settings',
            '2025_07_02_125622_create_private_credit_notification_settings',
        ])
        ->runsSettings()
        ->hasDependencies([
            'private-credit-website',
        ])
        ->hasSeeder('Catalyst\\PrivateCredit\\Database\\Seeders\\DatabaseSeeder')
        ->hasInstallCommand(function (InstallCommand $command) {
            $command
            ->installDependencies()
            ->runsMigrations()
            ->runsSeeders();
        })
        ->hasUninstallCommand(function (UninstallCommand $command) {});
    }

    public function packageBooted(): void
    {
        Livewire::component('repayment-schedule', RepaymentSchedule::class);

        Gate::policy(Investor::class, InvestorPolicy::class);
        Gate::policy(\Catalyst\PrivateCredit\Models\InvestorProduct::class, \Catalyst\PrivateCredit\Policies\InvestorProductPolicy::class);
    }
}
