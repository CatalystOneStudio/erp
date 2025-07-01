<?php

namespace Catalyst\PrivateCredit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'private_credit_banks';

    protected $fillable = [
        'name',
        'swift_code',
        'routing_number',
        'country',
    ];
}
