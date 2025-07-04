<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('private_credit_general.company_name', 'Catalyst');
        $this->migrator->add('private_credit_general.currency', 'USD');
        $this->migrator->add('private_credit_general.address', '');
        $this->migrator->add('private_credit_general.timezone', 'UTC-04:00');
        $this->migrator->add('private_credit_general.phone_number', '');
        $this->migrator->add('private_credit_general.decimal_places_to_round_off_every_amount_to', 2);
        $this->migrator->add('private_credit_general.company_logo', '');
    }

    public function down(): void
    {
        $this->migrator->deleteIfExists('private_credit_general.company_name');
        $this->migrator->deleteIfExists('private_credit_general.currency');
        $this->migrator->deleteIfExists('private_credit_general.address');
        $this->migrator->deleteIfExists('private_credit_general.timezone');
        $this->migrator->deleteIfExists('private_credit_general.phone_number');
        $this->migrator->deleteIfExists('private_credit_general.decimal_places_to_round_off_every_amount_to');
        $this->migrator->deleteIfExists('private_credit_general.company_logo');
    }
};
