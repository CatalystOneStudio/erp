<?php

namespace Catalyst\PrivateCredit\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Catalyst\PrivateCredit\Models\Fee;

class LoanProductFeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Fee::create([
            'name' => 'Processing Fee',
            'type' => 'percentage',
            'calculate_on' => 'principal',
            'value' => 2,
            'is_active_deduct_from_principal' => true,
            'is_active_spread_across_repayments' => false,
        ]);

        Fee::create([
            'name' => 'Application Fee',
            'type' => 'fixed',
            'calculate_on' => 'principal',
            'value' => 50,
            'is_active_deduct_from_principal' => false,
            'is_active_spread_across_repayments' => true,
        ]);

        Fee::create([
            'name' => 'Late Payment Fee',
            'type' => 'fixed',
            'calculate_on' => 'principal_and_interest',
            'value' => 25,
            'is_active_deduct_from_principal' => true,
            'is_active_spread_across_repayments' => true,
        ]);
    }
}
