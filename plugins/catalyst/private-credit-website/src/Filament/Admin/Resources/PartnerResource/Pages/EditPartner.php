<?php

namespace Catalyst\PrivateCreditWebsite\Filament\Admin\Resources\PartnerResource\Pages;

use Webkul\Partner\Filament\Resources\PartnerResource\Pages\EditPartner as BaseEditPartner;
use Catalyst\PrivateCreditWebsite\Filament\Admin\Resources\PartnerResource;

class EditPartner extends BaseEditPartner
{
    protected static string $resource = PartnerResource::class;
}
