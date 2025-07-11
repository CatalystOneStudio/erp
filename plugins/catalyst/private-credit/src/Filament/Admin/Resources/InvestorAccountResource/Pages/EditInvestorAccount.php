<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorAccountResource\Pages;

use Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInvestorAccount extends EditRecord
{
    protected static string $resource = InvestorAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
