<?php

namespace Catalyst\PrivateCredit\Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BankSeeder::class,
            FundingAccountSeeder::class,
            ChartOfAccountSeeder::class,
            LoanProductSeeder::class,
            LoanProductFeeSeeder::class,
        ]);
    }
}
