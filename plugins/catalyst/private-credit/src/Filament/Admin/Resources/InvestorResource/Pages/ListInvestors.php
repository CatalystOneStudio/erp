<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorResource\Pages;

use Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvestors extends ListRecords
{
    protected static string $resource = InvestorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
