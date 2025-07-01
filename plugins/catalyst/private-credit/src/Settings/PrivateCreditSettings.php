<?php

namespace Catalyst\PrivateCredit\Settings;

use Spatie\LaravelSettings\Settings;

class PrivateCreditSettings extends Settings
{
    public ?string $financial_year_start_date;

    public static function group(): string
    {
        return 'private_credit';
    }
}
