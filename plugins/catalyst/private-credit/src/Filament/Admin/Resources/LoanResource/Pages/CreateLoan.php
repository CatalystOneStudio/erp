<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources\LoanResource\Pages;

use Catalyst\PrivateCredit\Filament\Admin\Resources\LoanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLoan extends CreateRecord
{
    protected static string $resource = LoanResource::class;
}
