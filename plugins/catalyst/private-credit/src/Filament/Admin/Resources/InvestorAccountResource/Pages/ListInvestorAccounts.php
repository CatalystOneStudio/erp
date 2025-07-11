<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorAccountResource\Pages;

use Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvestorAccounts extends ListRecords
{
    protected static string $resource = InvestorAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
