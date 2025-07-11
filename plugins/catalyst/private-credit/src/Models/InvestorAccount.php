<?php

namespace Catalyst\PrivateCredit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Catalyst\PrivateCredit\Models\Investor;
use Catalyst\PrivateCredit\Models\InvestorProduct;

class InvestorAccount extends Model
{
    use HasFactory;

    protected $table = 'private_credit_investor_accounts';

    protected $fillable = [
        'investor_id',
        'investor_product_id',
        'account_code',
        'balance',
        'total_deposits',
        'total_withdrawals',
        'total_bank_fees',
        'total_interest_earned',
    ];

    protected $casts = [
        'last_transaction_date' => 'datetime',
        'balance' => 'decimal:2',
        'interest_rate' => 'decimal:4',
        'total_deposits' => 'decimal:2',
        'total_withdrawals' => 'decimal:2',
        'total_bank_fees' => 'decimal:2',
        'total_interest_earned' => 'decimal:2',
    ];

    public function investor(): BelongsTo
    {
        return $this->belongsTo(Investor::class);
    }

    public function investorProduct(): BelongsTo
    {
        return $this->belongsTo(InvestorProduct::class);
    }
}
