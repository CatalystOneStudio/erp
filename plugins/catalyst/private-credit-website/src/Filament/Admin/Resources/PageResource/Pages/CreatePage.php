<?php

namespace Catalyst\PrivateCreditWebsite\Filament\Admin\Resources\PageResource\Pages;

use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Catalyst\PrivateCreditWebsite\Filament\Admin\Resources\PageResource;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }

    protected function getCreatedNotification(): Notification
    {
        return Notification::make()
            ->success()
            ->title(__('private-credit-website::filament/admin/resources/page/pages/create-record.notification.title'))
            ->body(__('private-credit-website::filament/admin/resources/page/pages/create-record.notification.body'));
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['creator_id'] = Auth::id();

        return $data;
    }
}
