<?php

namespace Catalyst\PrivateCredit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'private_credit_discounts';

    protected $fillable = [
        'loan_id',
        'name',
        'type',
        'value',
    ];

    protected $casts = [
        'value' => 'decimal:2',
    ];
}
