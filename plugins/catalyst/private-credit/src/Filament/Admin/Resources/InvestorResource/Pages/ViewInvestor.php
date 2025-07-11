<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorResource\Pages;

use Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Actions\ActionGroup;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;

class ViewInvestor extends ViewRecord
{
    protected static string $resource = InvestorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Personal Information')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('first_name'),
                        TextEntry::make('last_name'),
                        TextEntry::make('gender'),
                        TextEntry::make('date_of_birth')
                            ->date(),
                        TextEntry::make('identification_type'),
                        TextEntry::make('identification_value'),
                        TextEntry::make('tax_identification_number'),
                        ImageEntry::make('avatar')
                            ->disk('public')
                            ->visibility('private'),
                    ]),
                Section::make('Contact Information')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('primary_phone_number'),
                        TextEntry::make('secondary_phone_number'),
                        TextEntry::make('email'),
                        TextEntry::make('address'),
                        TextEntry::make('city'),
                        TextEntry::make('state_province'),
                        TextEntry::make('zipcode'),
                    ]),
                Section::make('Additional Information')
                    ->schema([
                        TextEntry::make('description')
                            ->columnSpanFull(),
                        ImageEntry::make('files')
                            ->height(400)
                    ]),
            ]);
    }
}
