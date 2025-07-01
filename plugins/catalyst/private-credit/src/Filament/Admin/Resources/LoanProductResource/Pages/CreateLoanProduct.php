<?php

namespace Catalyst\PrivateCredit\Filament\Admin\Resources\LoanProductResource\Pages;

use Catalyst\PrivateCredit\Filament\Admin\Resources\LoanProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLoanProduct extends CreateRecord
{
    protected static string $resource = LoanProductResource::class;
}
