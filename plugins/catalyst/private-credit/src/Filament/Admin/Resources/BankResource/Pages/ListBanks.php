<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources\BankResource\Pages;

use Catalyst\PrivateCredit\Filament\Admin\Resources\BankResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBanks extends ListRecords
{
    protected static string $resource = BankResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
