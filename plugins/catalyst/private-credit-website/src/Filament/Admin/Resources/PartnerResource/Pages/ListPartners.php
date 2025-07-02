<?php

namespace Catalyst\PrivateCreditWebsite\Filament\Admin\Resources\PartnerResource\Pages;

use Webkul\Partner\Filament\Resources\PartnerResource\Pages\ListPartners as BaseListPartners;
use Catalyst\PrivateCreditWebsite\Filament\Admin\Resources\PartnerResource;

class ListPartners extends BaseListPartners
{
    protected static string $resource = PartnerResource::class;
}
