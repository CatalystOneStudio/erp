<?php

namespace Catalyst\PrivateCredit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Catalyst\PrivateCredit\Models\Fee;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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

    /**
     * Get all of the loan's fees.
     */
    public function fees(): MorphMany
    {
        return $this->morphMany(Fee::class, 'feesable');
    }

    /**
     * Delete loan record and related fee records.
     */
    public static function destroy($ids)
    {
        $ids = value(function () use($ids) {
            if ($ids instanceof \Illuminate\Database\Eloquent\Collection) return $ids->modelKeys();
            if ($ids instanceof \Illuminate\Support\Collection) return $ids->all();
            return is_array($ids) ? $ids : func_get_args();
        });

        if (count($ids) === 0) return 0;

        $deleted_record_ids = array_map(
            function ($id) {
                self::fees()->where('id', $id)->destroy();
                if (self::where('id', $id)->delete()) return $id;
            }, $ids
        );

        return count($deleted_record_ids);
    }
}
