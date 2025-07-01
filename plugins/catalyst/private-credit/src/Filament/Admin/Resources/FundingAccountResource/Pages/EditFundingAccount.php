<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources\FundingAccountResource\Pages;

use Catalyst\PrivateCredit\Filament\Admin\Resources\FundingAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFundingAccount extends EditRecord
{
    protected static string $resource = FundingAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
