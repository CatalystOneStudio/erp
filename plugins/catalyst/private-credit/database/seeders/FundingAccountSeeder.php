<?php

namespace Catalyst\PrivateCredit\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FundingAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('private_credit_funding_accounts')->insert([
            [
                'id' => 1,
                'parent_id' => null,
                'name' => 'Cash',
                'code' => '1001',
                'currency' => 'TTD',
                'account_type' => 'cash',
                'bank_id' => null,
                'bank_account_number' => null,
                'bank_account_holder_name' => null,
                'status' => true,
            ],
            [
                'id' => 2,
                'parent_id' => null,
                'name' => 'Bank',
                'code' => '1002',
                'currency' => 'TTD',
                'account_type' => 'bank',
                'bank_id' => null,
                'bank_account_number' => null,
                'bank_account_holder_name' => null,
                'status' => true,
            ]
        ]);
    }
}
