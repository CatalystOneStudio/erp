<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources\LoanProductResource\Pages;

use Catalyst\PrivateCredit\Filament\Admin\Resources\LoanProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLoanProducts extends ListRecords
{
    protected static string $resource = LoanProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
