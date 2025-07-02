<?php

namespace Catalyst\PrivateCreditWebsite\Filament\Admin\Resources\PartnerResource\Pages;

use Webkul\Partner\Filament\Resources\PartnerResource\Pages\ManageAddresses as BaseManageAddresses;
use Catalyst\PrivateCreditWebsite\Filament\Admin\Resources\PartnerResource;

class ManageAddresses extends BaseManageAddresses
{
    protected static string $resource = PartnerResource::class;
}
