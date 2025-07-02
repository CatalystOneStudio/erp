<?php

namespace Catalyst\PrivateCredit\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public ?string $company_name;
    public ?string $currency;
    public ?string $address;
    public ?string $timezone;
    public ?string $phone_number;
    public ?int $decimal_places_to_round_off_every_amount_to;
    public ?string $company_logo;

    public static function group(): string
    {
        return 'private_credit_general';
    }
}
