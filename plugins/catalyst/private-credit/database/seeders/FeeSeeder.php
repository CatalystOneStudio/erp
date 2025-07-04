<?php

namespace Catalyst\PrivateCredit\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Catalyst\PrivateCredit\Models\Fee;

class FeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Fee::create([
            'feesable_id' => 1,
            'feesable_type' => 'loan_product',
            'name' => 'Processing Fee',
            'type' => 'percentage',
            'calculate_on' => 'principal',
            'value' => 2,
            'is_active_deduct_from_principal' => true,
            'is_active_spread_across_repayments' => false,
        ]);

        Fee::create([
            'feesable_id' => 2,
            'feesable_type' => 'loan_product',
            'name' => 'Application Fee',
            'type' => 'fixed',
            'calculate_on' => 'principal',
            'value' => 50,
            'is_active_deduct_from_principal' => false,
            'is_active_spread_across_repayments' => true,
        ]);

        Fee::create([
            'feesable_id' => 3,
            'feesable_type' => 'loan_product',
            'name' => 'Late Payment Fee',
            'type' => 'fixed',
            'calculate_on' => 'principal_and_interest',
            'value' => 25,
            'is_active_deduct_from_principal' => true,
            'is_active_spread_across_repayments' => true,
        ]);
    }
}
