<?php

namespace Catalyst\PrivateCreditWebsite\Filament\Admin\Resources\PartnerResource\Pages;

use Webkul\Partner\Filament\Resources\PartnerResource\Pages\ViewPartner as BaseViewPartner;
use Catalyst\PrivateCreditWebsite\Filament\Admin\Resources\PartnerResource;

class ViewPartner extends BaseViewPartner
{
    protected static string $resource = PartnerResource::class;
}
