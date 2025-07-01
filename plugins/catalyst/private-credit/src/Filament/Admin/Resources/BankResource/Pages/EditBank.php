<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources\BankResource\Pages;

use Catalyst\PrivateCredit\Filament\Admin\Resources\BankResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBank extends EditRecord
{
    protected static string $resource = BankResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
