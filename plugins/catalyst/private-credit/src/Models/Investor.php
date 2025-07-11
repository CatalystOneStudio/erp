<?php

namespace Catalyst\PrivateCredit\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    use HasFactory;

    protected $table = 'private_credit_investors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'identification_type',
        'identification_value',
        'tax_identification_number',
        'primary_phone_number',
        'secondary_phone_number',
        'email',
        'address',
        'city',
        'state_province',
        'zipcode',
        'description',
        'avatar',
        'files',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'files' => 'array',
    ];

    public function getNameAttribute() : string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
