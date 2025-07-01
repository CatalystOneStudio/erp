<?php

namespace Catalyst\PrivateCredit\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Catalyst\PrivateCredit\Models\LoanProduct;
use Catalyst\PrivateCredit\Models\ChartOfAccount;
use Catalyst\PrivateCredit\Models\FundingAccount;

class LoanProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fundingAccount = FundingAccount::where('name', 'Bank')->first();
        $loansReceivableAccount = ChartOfAccount::where('name', 'Loans Receivable')->first();
        $interestIncomeAccount = ChartOfAccount::where('name', 'Interest Income')->first();
        $feesIncomeAccount = ChartOfAccount::where('name', 'Fees Income')->first();
        $penaltyIncomeAccount = ChartOfAccount::where('name', 'Penalties Income')->first();
        $overpaymentAccount = ChartOfAccount::where('name', 'Loans Overpayment')->first();

        LoanProduct::create([
            'name' => 'Personal Loan',
            'description' => 'Standard personal loan product.',
            'is_active' => true,
            'min_principal_amount' => 1000,
            'max_principal_amount' => 10000,
            'duration_period' => 'months',
            'duration_type' => 'fixed',
            'duration_value' => 12,
            'repayment_cycle' => 'monthly',
            'interest_rate_type' => 'flat',
            'interest_rate' => 10,
            'interest_cycle' => 'per-month',
            'late_penalty_is_active' => true,
            'late_penalty_type' => 'percentage',
            'late_penalty_calculate_on' => 'principal_and_interest',
            'late_penalty_amount' => 5,
            'late_penalty_grace_period' => 7,
            'late_penalty_recurring' => 'once',
            'funding_account_id' => $fundingAccount->id,
            'loans_receivable_account_id' => $loansReceivableAccount->id,
            'default_interest_income_account_id' => $interestIncomeAccount->id,
            'default_fees_income_account_id' => $feesIncomeAccount->id,
            'default_penalty_income_account_id' => $penaltyIncomeAccount->id,
            'default_overpayment_account_id' => $overpaymentAccount->id,
        ]);

        LoanProduct::create([
            'name' => 'Car Loan',
            'description' => 'Loan product for purchasing a car.',
            'is_active' => true,
            'min_principal_amount' => 5000,
            'max_principal_amount' => 50000,
            'duration_period' => 'years',
            'duration_type' => 'fixed',
            'duration_value' => 5,
            'repayment_cycle' => 'monthly',
            'interest_rate_type' => 'armotized',
            'interest_rate' => 7,
            'interest_cycle' => 'per-month',
            'late_penalty_is_active' => false,
            'funding_account_id' => $fundingAccount->id,
            'loans_receivable_account_id' => $loansReceivableAccount->id,
            'default_interest_income_account_id' => $interestIncomeAccount->id,
            'default_fees_income_account_id' => $feesIncomeAccount->id,
            'default_penalty_income_account_id' => $penaltyIncomeAccount->id,
            'default_overpayment_account_id' => $overpaymentAccount->id,
        ]);

        LoanProduct::create([
            'name' => 'Mortgage Loan',
            'description' => 'Long-term loan for real estate.',
            'is_active' => true,
            'min_principal_amount' => 50000,
            'max_principal_amount' => 500000,
            'duration_period' => 'years',
            'duration_type' => 'fixed',
            'duration_value' => 30,
            'repayment_cycle' => 'monthly',
            'interest_rate_type' => 'armotized',
            'interest_rate' => 4,
            'interest_cycle' => 'per-month',
            'late_penalty_is_active' => true,
            'late_penalty_type' => 'fixed',
            'late_penalty_calculate_on' => 'principal',
            'late_penalty_amount' => 50,
            'late_penalty_grace_period' => 15,
            'late_penalty_recurring' => 'monthly',
            'funding_account_id' => $fundingAccount->id,
            'loans_receivable_account_id' => $loansReceivableAccount->id,
            'default_interest_income_account_id' => $interestIncomeAccount->id,
            'default_fees_income_account_id' => $feesIncomeAccount->id,
            'default_penalty_income_account_id' => $penaltyIncomeAccount->id,
            'default_overpayment_account_id' => $overpaymentAccount->id,
        ]);
    }
}
