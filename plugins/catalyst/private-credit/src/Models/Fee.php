<?php

namespace Catalyst\PrivateCredit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    use HasFactory;

    protected $table = 'private_credit_fees';

    protected $fillable = [
        'name',
        'type',
        'calculate_on',
        'value',
        'is_active_deduct_from_principal',
        'is_active_spread_across_repayments',
    ];

    protected $casts = [
        'is_active_deduct_from_principal' => 'boolean',
        'is_active_spread_across_repayments' => 'boolean',
    ];

    public function loanProducts()
    {
        return $this->belongsToMany(LoanProduct::class, 'private_credit_loan_product_fee');
    }
}
