<?php

namespace Catalyst\PrivateCredit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestorProduct extends Model
{
    use HasFactory;

    protected $table = 'private_credit_investor_products';

    protected $fillable = [
        'name',
        'description',
        'interest_type',
        'interest_rate',
        'interest_cycle',
    ];

    protected $casts = [
        'interest_rate' => 'decimal:4',
    ];
}
