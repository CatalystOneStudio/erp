<?php

namespace Catalyst\PrivateCreditWebsite\Filament\Admin\Resources\PartnerResource\Pages;

use Webkul\Partner\Filament\Resources\PartnerResource\Pages\ManageContacts as BaseManageContacts;
use Catalyst\PrivateCreditWebsite\Filament\Admin\Resources\PartnerResource;

class ManageContacts extends BaseManageContacts
{
    protected static string $resource = PartnerResource::class;
}
