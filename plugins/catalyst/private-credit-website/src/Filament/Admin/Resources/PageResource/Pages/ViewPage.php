<?php

namespace Catalyst\PrivateCreditWebsite\Filament\Admin\Resources\PageResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Catalyst\PrivateCreditWebsite\Filament\Admin\Resources\PageResource;

class ViewPage extends ViewRecord
{
    protected static string $resource = PageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title(__('private-credit-website::filament/admin/resources/page/pages/view-record.header-actions.delete.notification.title'))
                        ->body(__('private-credit-website::filament/admin/resources/page/pages/view-record.header-actions.delete.notification.body')),
                ),
        ];
    }
}
