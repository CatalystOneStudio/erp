<?php

namespace Catalyst\PrivateCredit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Catalyst\PrivateCredit\Models\Fee;

class LoanProduct extends Model
{
    use HasFactory;

    protected $table = 'private_credit_loan_products';

    protected $fillable = [
        'name',
        'description',
        'is_active',
        'min_principal_amount',
        'max_principal_amount',
        'duration_period',
        'duration_type',
        'duration_value',
        'duration_min_value',
        'duration_max_value',
        'repayment_cycle',
        'interest_rate_type',
        'interest_rate',
        'interest_cycle',
        'late_penalty_is_active',
        'late_penalty_type',
        'late_penalty_calculate_on',
        'late_penalty_amount',
        'late_penalty_grace_period',
        'late_penalty_recurring',
        'funding_account_id',
        'loans_receivable_account_id',
        'default_interest_income_account_id',
        'default_fees_income_account_id',
        'default_penalty_income_account_id',
        'default_overpayment_account_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'late_penalty_is_active' => 'boolean',
    ];

    public function fees()
    {
        return $this->belongsToMany(Fee::class, 'private_credit_loan_product_fee');
    }
}
