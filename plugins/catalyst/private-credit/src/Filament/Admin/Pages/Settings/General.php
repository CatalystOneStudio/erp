<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Pages\Settings;

use Catalyst\PrivateCredit\Models\Timezone;
use Catalyst\PrivateCredit\Settings\GeneralSettings;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;
use Webkul\Support\Filament\Clusters\Settings;
use Webkul\Support\Models\Currency;

class General extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = GeneralSettings::class;

    protected static ?string $cluster = Settings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('private-credit::filament/pages/settings/general.company_information_heading'))
                    ->description(__('private-credit::filament/pages/settings/general.company_information_description'))
                    ->schema([
                        TextInput::make('company_name')
                            ->label(__('private-credit::filament/pages/settings/general.company_name_label'))
                            ->required(),
                        Select::make('currency')
                            ->label(__('private-credit::filament/pages/settings/general.currency_label'))
                            ->searchable()
                            ->options(Currency::query()->pluck('name'))
                            ->optionsLimit(169)
                            ->required(),
                        TextInput::make('address')
                            ->label(__('private-credit::filament/pages/settings/general.address_label')),
                        Select::make('timezone')
                            ->label(__('private-credit::filament/pages/settings/general.timezone_label'))
                            ->searchable()
                            ->options(Timezone::query()->pluck('name', 'offset'))
                            ->optionsLimit(418)
                            ->required(),
                        TextInput::make('phone_number')
                            ->label(__('private-credit::filament/pages/settings/general.phone_number_label'))
                            ->tel(),
                        TextInput::make('decimal_places_to_round_off_every_amount_to')
                            ->label(__('private-credit::filament/pages/settings/general.decimal_places_to_round_off_every_amount_to_label'))
                            ->numeric()
                            ->required(),
                    ])->columns(2),

                Section::make(__('private-credit::filament/pages/settings/general.company_logo_heading'))
                    ->description(__('private-credit::filament/pages/settings/general.company_logo_description'))
                    ->schema([
                        FileUpload::make('company_logo')
                            ->label(__('private-credit::filament/pages/settings/general.company_logo_label'))
                            ->image()
                            ->maxSize(10240)
                            ->directory('logos')
                            ->visibility('public'),
                    ]),
            ]);
    }
}
