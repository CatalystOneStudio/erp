<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Pages\Settings;

use Catalyst\PrivateCredit\Settings\NotificationSettings;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\SettingsPage;
use Webkul\Support\Filament\Clusters\Settings;

class Notifications extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-bell';

    protected static string $settings = NotificationSettings::class;

    protected static ?string $cluster = Settings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('private-credit::filament/pages/settings/notifications.daily_account_summary_heading'))
                    ->description(__('private-credit::filament/pages/settings/notifications.daily_account_summary_description'))
                    ->schema($this->createNotificationTypeSchema(type: 'daily_account_summary', hidden: ['sms', 'template'])),

                Section::make(__('private-credit::filament/pages/settings/notifications.reminders_heading'))
                    ->description(__('private-credit::filament/pages/settings/notifications.reminders_description'))
                    ->schema([
                        ...$this->createNotificationTypeSchema(
                            'two_day_due_reminder',
                            __('private-credit::filament/pages/settings/notifications.two_day_due_reminder.label'),
                            __('private-credit::filament/pages/settings/notifications.two_day_due_reminder.description')
                        ),
                        ...$this->createNotificationTypeSchema(
                            'one_day_due_reminder',
                            __('private-credit::filament/pages/settings/notifications.one_day_due_reminder.label'),
                            __('private-credit::filament/pages/settings/notifications.one_day_due_reminder.description')
                        ),
                        ...$this->createNotificationTypeSchema(
                            'due_date_reminder',
                            __('private-credit::filament/pages/settings/notifications.due_date_reminder.label'),
                            __('private-credit::filament/pages/settings/notifications.due_date_reminder.description')
                        ),
                        ...$this->createNotificationTypeSchema(
                            'overdue_reminders',
                            __('private-credit::filament/pages/settings/notifications.overdue_reminders.label'),
                            __('private-credit::filament/pages/settings/notifications.overdue_reminders.description')
                        ),
                    ]),

                Section::make(__('private-credit::filament/pages/settings/notifications.loan_status_changes_heading'))
                    ->description(__('private-credit::filament/pages/settings/notifications.loan_status_changes_description'))
                    ->schema([
                        ...$this->createNotificationTypeSchema(
                            'loan_active',
                            __('private-credit::filament/pages/settings/notifications.loan_active.label'),
                            __('private-credit::filament/pages/settings/notifications.loan_active.description')
                        ),
                        ...$this->createNotificationTypeSchema(
                            'loan_completion',
                            __('private-credit::filament/pages/settings/notifications.loan_completion.label'),
                            __('private-credit::filament/pages/settings/notifications.loan_completion.description')
                        ),
                        ...$this->createNotificationTypeSchema(
                            'loan_default',
                            __('private-credit::filament/pages/settings/notifications.loan_default.label'),
                            __('private-credit::filament/pages/settings/notifications.loan_default.description')
                        ),
                    ]),

                Section::make(__('private-credit::filament/pages/settings/notifications.payment_notifications_heading'))
                    ->description(__('private-credit::filament/pages/settings/notifications.payment_notifications_description'))
                    ->schema($this->createNotificationTypeSchema('payment_received')),

                Section::make(__('private-credit::filament/pages/settings/notifications.investors_heading'))
                    ->description(__('private-credit::filament/pages/settings/notifications.investors_description'))
                    ->schema([
                        ...$this->createNotificationTypeSchema(
                            'deposit_investor',
                            __('private-credit::filament/pages/settings/notifications.deposit_investor.label'),
                            __('private-credit::filament/pages/settings/notifications.deposit_investor.description')
                        ),
                        ...$this->createNotificationTypeSchema(
                            'withdraw_investor',
                            __('private-credit::filament/pages/settings/notifications.withdraw_investor.label'),
                            __('private-credit::filament/pages/settings/notifications.withdraw_investor.description')
                        ),
                        ...$this->createNotificationTypeSchema(
                            'bank_fee_applied_investor',
                            __('private-credit::filament/pages/settings/notifications.bank_fee_applied_investor.label'),
                            __('private-credit::filament/pages/settings/notifications.bank_fee_applied_investor.description')
                        ),
                    ]),
            ]);
    }

    protected function createNotificationTypeSchema(string $type, ?string $label = null, ?string $description = null, array $hidden = []): array
    {
        return [
            Section::make($label)
            ->description($description)
            ->compact()
            ->schema([
                Grid::make(4)
                    ->schema([
                        Toggle::make("{$type}_email_enabled")
                            ->label(__('private-credit::filament/pages/settings/notifications.email_label'))
                            ->hidden(in_array('email', $hidden)),
                        Toggle::make("{$type}_sms_enabled")
                            ->label(__('private-credit::filament/pages/settings/notifications.sms_label'))
                            ->hidden(in_array('sms', $hidden)),
                        // TODO: Intergrate whatsapp notifications
                        // Toggle::make("{$type}_whatsapp_enabled")
                        //     ->label(__('private-credit::filament/pages/settings/notifications.whatsapp_label')),
                        // TODO: Implement custom templates for notifications
                        // Actions::make([
                        //     Action::make($type . '_templates')
                        //         ->label(__('private-credit::filament/pages/settings/notifications.templates_label'))
                        //         ->form(fn (Form $form) => $this->createTemplateForm($form, $type))
                        //         ->action(function (array $data, Form $form) use ($type) {
                        //             $this->updateTemplates($type, $data);
                        //             Notification::make()
                        //                 ->title(__('private-credit::filament/pages/settings/notifications.templates_updated_notification_title'))
                        //                 ->success()
                        //                 ->send();
                        //         }),
                        // ])->label('')
                        // ->hidden(in_array('template', $hidden)),
                    ]),
            ])
        ];
    }

    protected function createTemplateForm(Form $form, string $type): Form
    {
        return $form->schema([
            Tabs::make('channels')
                ->tabs([
                    Tabs\Tab::make('email')
                        ->label(__('private-credit::filament/pages/settings/notifications.email_label'))
                        ->schema($this->createTemplateChannelSchema($type, 'email')),
                    Tabs\Tab::make('sms')
                        ->label(__('private-credit::filament/pages/settings/notifications.sms_label'))
                        ->schema($this->createTemplateChannelSchema($type, 'sms')),
                    Tabs\Tab::make('whatsapp')
                        ->label(__('private-credit::filament/pages/settings/notifications.whatsapp_label'))
                        ->schema($this->createTemplateChannelSchema($type, 'whatsapp')),
                ]),
        ]);
    }

    protected function createTemplateChannelSchema(string $type, string $channel): array
    {
        return [
            Radio::make("{$type}_templates.{$channel}.type")
                ->label(__('private-credit::filament/pages/settings/notifications.template_type_label'))
                ->options([
                    'predefined' => __('private-credit::filament/pages/settings/notifications.predefined_template_option'),
                    'custom' => __('private-credit::filament/pages/settings/notifications.custom_template_option'),
                ])
                ->default('predefined')
                ->reactive(),
            Select::make("{$type}_templates.{$channel}.predefined_template")
                ->label(__('private-credit::filament/pages/settings/notifications.select_template_label'))
                ->options([
                    'default' => __('private-credit::filament/pages/settings/notifications.default_template_label'),
                ])
                ->visible(fn ($get) => $get("{$type}_templates.{$channel}.type") === 'predefined'),
            Textarea::make("{$type}_templates.{$channel}.custom_template")
                ->label(__('private-credit::filament/pages/settings/notifications.custom_template_label'))
                ->visible(fn ($get) => $get("{$type}_templates.{$channel}.type") === 'custom'),
        ];
    }

    protected function updateTemplates(string $type, array $data): void
    {
        $settings = app(NotificationSettings::class);
        $templates = $settings->{$type . '_templates'};
        $templates = array_merge($templates, $data[$type . '_templates']);
        $settings->{$type . '_templates'} = $templates;
        $settings->save();
    }
}
