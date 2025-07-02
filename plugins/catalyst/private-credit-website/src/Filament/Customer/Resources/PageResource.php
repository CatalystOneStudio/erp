<?php

namespace Catalyst\PrivateCreditWebsite\Filament\Customer\Resources;

use Filament\Resources\Resource;
use Catalyst\PrivateCreditWebsite\Filament\Customer\Resources\PageResource\Pages;
use Catalyst\PrivateCreditWebsite\Models\Page;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $recordRouteKeyName = 'slug';

    protected static bool $shouldRegisterNavigation = false;

    protected static bool $shouldSkipAuthorization = true;

    public static function getPages(): array
    {
        return [
            'view' => Pages\ViewPage::route('/{record}'),
        ];
    }
}
