<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('private_credit.financial_year_start_date', '2025-01-01');
    }

    public function down(): void
    {
        $this->migrator->deleteIfExists('private_credit.financial_year_start_date');
    }
};
