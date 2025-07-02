<?php

namespace Catalyst\PrivateCreditWebsite\Filament\Admin\Resources\PartnerResource\Pages;

use Webkul\Partner\Filament\Resources\PartnerResource\Pages\CreatePartner as BaseCreatePartner;
use Catalyst\PrivateCreditWebsite\Filament\Admin\Resources\PartnerResource;

class CreatePartner extends BaseCreatePartner
{
    protected static string $resource = PartnerResource::class;
}
