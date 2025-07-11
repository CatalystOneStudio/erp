<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorProductResource\Pages;

use Catalyst\PrivateCredit\Filament\Admin\Resources\InvestorProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvestorProducts extends ListRecords
{
    protected static string $resource = InvestorProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
