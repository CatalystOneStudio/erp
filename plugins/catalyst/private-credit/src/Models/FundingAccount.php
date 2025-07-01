<?php

namespace Catalyst\PrivateCredit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FundingAccount extends Model
{
    use HasFactory;

    protected $table = 'private_credit_funding_accounts';

    protected $fillable = [
        'parent_id',
        'name',
        'code',
        'currency',
        'account_type',
        'bank_id',
        'bank_account_number',
        'bank_account_holder_name',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(FundingAccount::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(FundingAccount::class, 'parent_id');
    }

    public function bank(): BelongsTo
    {
        return $this->belongsTo(Bank::class);
    }
}
