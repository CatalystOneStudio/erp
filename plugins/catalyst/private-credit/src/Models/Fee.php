<?php

namespace Catalyst\PrivateCredit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Fee extends Model
{
    use HasFactory;

    protected $table = 'private_credit_fees';

    protected $fillable = [
        'feesable_id',
        'feesable_type',
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

    /**
     * Get the parent feesable model (loan_product or loan)
     */
    public function feesable(): MorphTo
    {
        return $this->morphTo();
    }
}
