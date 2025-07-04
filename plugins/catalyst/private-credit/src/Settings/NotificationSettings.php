<?php

namespace Catalyst\PrivateCredit\Settings;

use Spatie\LaravelSettings\Settings;

class NotificationSettings extends Settings
{
    public bool $daily_account_summary_email_enabled;
    public bool $daily_account_summary_sms_enabled;
    public bool $daily_account_summary_whatsapp_enabled;
    public array $daily_account_summary_templates;

    public bool $two_day_due_reminder_email_enabled;
    public bool $two_day_due_reminder_sms_enabled;
    public bool $two_day_due_reminder_whatsapp_enabled;
    public array $two_day_due_reminder_templates;

    public bool $one_day_due_reminder_email_enabled;
    public bool $one_day_due_reminder_sms_enabled;
    public bool $one_day_due_reminder_whatsapp_enabled;
    public array $one_day_due_reminder_templates;

    public bool $due_date_reminder_email_enabled;
    public bool $due_date_reminder_sms_enabled;
    public bool $due_date_reminder_whatsapp_enabled;
    public array $due_date_reminder_templates;

    public bool $overdue_reminders_email_enabled;
    public bool $overdue_reminders_sms_enabled;
    public bool $overdue_reminders_whatsapp_enabled;
    public array $overdue_reminders_templates;

    public bool $loan_active_email_enabled;
    public bool $loan_active_sms_enabled;
    public bool $loan_active_whatsapp_enabled;
    public array $loan_active_templates;

    public bool $loan_completion_email_enabled;
    public bool $loan_completion_sms_enabled;
    public bool $loan_completion_whatsapp_enabled;
    public array $loan_completion_templates;

    public bool $loan_default_email_enabled;
    public bool $loan_default_sms_enabled;
    public bool $loan_default_whatsapp_enabled;
    public array $loan_default_templates;

    public bool $payment_received_email_enabled;
    public bool $payment_received_sms_enabled;
    public bool $payment_received_whatsapp_enabled;
    public array $payment_received_templates;

    public bool $deposit_investor_email_enabled;
    public bool $deposit_investor_sms_enabled;
    public bool $deposit_investor_whatsapp_enabled;
    public array $deposit_investor_templates;

    public bool $withdraw_investor_email_enabled;
    public bool $withdraw_investor_sms_enabled;
    public bool $withdraw_investor_whatsapp_enabled;
    public array $withdraw_investor_templates;

    public bool $bank_fee_applied_investor_email_enabled;
    public bool $bank_fee_applied_investor_sms_enabled;
    public bool $bank_fee_applied_investor_whatsapp_enabled;
    public array $bank_fee_applied_investor_templates;

    public static function group(): string
    {
        return 'private_credit_notification';
    }
}
