<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('private_credit_notification.daily_account_summary_email_enabled', true);
        $this->migrator->add('private_credit_notification.daily_account_summary_sms_enabled', false);
        $this->migrator->add('private_credit_notification.daily_account_summary_whatsapp_enabled', false);
        $this->migrator->add('private_credit_notification.daily_account_summary_templates', []);

        $this->migrator->add('private_credit_notification.two_day_due_reminder_email_enabled', true);
        $this->migrator->add('private_credit_notification.two_day_due_reminder_sms_enabled', false);
        $this->migrator->add('private_credit_notification.two_day_due_reminder_whatsapp_enabled', false);
        $this->migrator->add('private_credit_notification.two_day_due_reminder_templates', []);

        $this->migrator->add('private_credit_notification.one_day_due_reminder_email_enabled', true);
        $this->migrator->add('private_credit_notification.one_day_due_reminder_sms_enabled', false);
        $this->migrator->add('private_credit_notification.one_day_due_reminder_whatsapp_enabled', false);
        $this->migrator->add('private_credit_notification.one_day_due_reminder_templates', []);

        $this->migrator->add('private_credit_notification.due_date_reminder_email_enabled', true);
        $this->migrator->add('private_credit_notification.due_date_reminder_sms_enabled', false);
        $this->migrator->add('private_credit_notification.due_date_reminder_whatsapp_enabled', false);
        $this->migrator->add('private_credit_notification.due_date_reminder_templates', []);

        $this->migrator->add('private_credit_notification.overdue_reminders_email_enabled', true);
        $this->migrator->add('private_credit_notification.overdue_reminders_sms_enabled', false);
        $this->migrator->add('private_credit_notification.overdue_reminders_whatsapp_enabled', false);
        $this->migrator->add('private_credit_notification.overdue_reminders_templates', []);

        $this->migrator->add('private_credit_notification.loan_active_email_enabled', true);
        $this->migrator->add('private_credit_notification.loan_active_sms_enabled', false);
        $this->migrator->add('private_credit_notification.loan_active_whatsapp_enabled', false);
        $this->migrator->add('private_credit_notification.loan_active_templates', []);

        $this->migrator->add('private_credit_notification.loan_completion_email_enabled', true);
        $this->migrator->add('private_credit_notification.loan_completion_sms_enabled', false);
        $this->migrator->add('private_credit_notification.loan_completion_whatsapp_enabled', false);
        $this->migrator->add('private_credit_notification.loan_completion_templates', []);

        $this->migrator->add('private_credit_notification.loan_default_email_enabled', true);
        $this->migrator->add('private_credit_notification.loan_default_sms_enabled', false);
        $this->migrator->add('private_credit_notification.loan_default_whatsapp_enabled', false);
        $this->migrator->add('private_credit_notification.loan_default_templates', []);

        $this->migrator->add('private_credit_notification.payment_received_email_enabled', true);
        $this->migrator->add('private_credit_notification.payment_received_sms_enabled', false);
        $this->migrator->add('private_credit_notification.payment_received_whatsapp_enabled', false);
        $this->migrator->add('private_credit_notification.payment_received_templates', []);

        $this->migrator->add('private_credit_notification.deposit_investor_email_enabled', true);
        $this->migrator->add('private_credit_notification.deposit_investor_sms_enabled', false);
        $this->migrator->add('private_credit_notification.deposit_investor_whatsapp_enabled', false);
        $this->migrator->add('private_credit_notification.deposit_investor_templates', []);

        $this->migrator->add('private_credit_notification.withdraw_investor_email_enabled', true);
        $this->migrator->add('private_credit_notification.withdraw_investor_sms_enabled', false);
        $this->migrator->add('private_credit_notification.withdraw_investor_whatsapp_enabled', false);
        $this->migrator->add('private_credit_notification.withdraw_investor_templates', []);

        $this->migrator->add('private_credit_notification.bank_fee_applied_investor_email_enabled', true);
        $this->migrator->add('private_credit_notification.bank_fee_applied_investor_sms_enabled', false);
        $this->migrator->add('private_credit_notification.bank_fee_applied_investor_whatsapp_enabled', false);
        $this->migrator->add('private_credit_notification.bank_fee_applied_investor_templates', []);
    }

    public function down(): void
    {
        $this->migrator->deleteIfExists('private_credit_notification.daily_account_summary_email_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.daily_account_summary_sms_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.daily_account_summary_whatsapp_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.daily_account_summary_templates');

        $this->migrator->deleteIfExists('private_credit_notification.two_day_due_reminder_email_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.two_day_due_reminder_sms_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.two_day_due_reminder_whatsapp_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.two_day_due_reminder_templates');

        $this->migrator->deleteIfExists('private_credit_notification.one_day_due_reminder_email_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.one_day_due_reminder_sms_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.one_day_due_reminder_whatsapp_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.one_day_due_reminder_templates');

        $this->migrator->deleteIfExists('private_credit_notification.due_date_reminder_email_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.due_date_reminder_sms_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.due_date_reminder_whatsapp_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.due_date_reminder_templates');

        $this->migrator->deleteIfExists('private_credit_notification.overdue_reminders_email_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.overdue_reminders_sms_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.overdue_reminders_whatsapp_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.overdue_reminders_templates');

        $this->migrator->deleteIfExists('private_credit_notification.loan_active_email_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.loan_active_sms_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.loan_active_whatsapp_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.loan_active_templates');

        $this->migrator->deleteIfExists('private_credit_notification.loan_completion_email_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.loan_completion_sms_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.loan_completion_whatsapp_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.loan_completion_templates');

        $this->migrator->deleteIfExists('private_credit_notification.loan_default_email_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.loan_default_sms_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.loan_default_whatsapp_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.loan_default_templates');

        $this->migrator->deleteIfExists('private_credit_notification.payment_received_email_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.payment_received_sms_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.payment_received_whatsapp_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.payment_received_templates');

        $this->migrator->deleteIfExists('private_credit_notification.deposit_investor_email_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.deposit_investor_sms_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.deposit_investor_whatsapp_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.deposit_investor_templates');

        $this->migrator->deleteIfExists('private_credit_notification.withdraw_investor_email_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.withdraw_investor_sms_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.withdraw_investor_whatsapp_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.withdraw_investor_templates');

        $this->migrator->deleteIfExists('private_credit_notification.bank_fee_applied_investor_email_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.bank_fee_applied_investor_sms_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.bank_fee_applied_investor_whatsapp_enabled');
        $this->migrator->deleteIfExists('private_credit_notification.bank_fee_applied_investor_templates');
    }
};
