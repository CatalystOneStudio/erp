<?php

namespace Catalyst\PrivateCredit\Database\Seeders;

use Catalyst\PrivateCredit\Models\ChartOfAccount;
use Illuminate\Database\Seeder;

class ChartOfAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chartOfAccounts = [
            [
                'name' => 'Loans Receivable',
                'code' => 1003,
                'account_type' => 'asset',
                'cashflow_type' => 'operating_activities',
            ],
            [
                'name' => 'Loans Overpayment',
                'code' => 1004,
                'account_type' => 'liability',
                'cashflow_type' => 'operating_activities',
            ],
            [
                'name' => 'Interest Income',
                'code' => 1005,
                'account_type' => 'income',
                'cashflow_type' => 'operating_activities',
            ],
            [
                'name' => 'Penalties Income',
                'code' => 1006,
                'account_type' => 'income',
                'cashflow_type' => 'operating_activities',
            ],
            [
                'name' => 'Fees Income',
                'code' => 1007,
                'account_type' => 'income',
                'cashflow_type' => 'operating_activities',
            ],
            [
                'name' => 'Recoveries Income',
                'code' => 1008,
                'account_type' => 'income',
                'cashflow_type' => 'operating_activities',
            ],
            [
                'name' => 'Defaulted Loans',
                'code' => 1009,
                'account_type' => 'expense',
                'cashflow_type' => 'operating_activities',
            ],
            [
                'name' => 'Owners Equity',
                'code' => 1010,
                'account_type' => 'equity',
                'cashflow_type' => 'financing_activities',
            ],
        ];

        foreach ($chartOfAccounts as $account) {
            ChartOfAccount::create($account);
        }
    }
}
