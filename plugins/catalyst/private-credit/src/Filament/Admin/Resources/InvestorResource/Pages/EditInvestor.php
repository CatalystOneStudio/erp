<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorResource\Pages;

use Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInvestor extends EditRecord
{
    protected static string $resource = InvestorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
