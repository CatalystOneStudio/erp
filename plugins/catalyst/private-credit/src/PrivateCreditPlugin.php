<?php

namespace Catalyst\PrivateCredit;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Webkul\Support\Package;

class PrivateCreditPlugin implements Plugin
{
    public function getId(): string
    {
        return 'private-credit';
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function register(Panel $panel): void
    {
        if (! Package::isPluginInstalled($this->getId())) return;

        $panel
            // ->when($panel->getId() == 'customer', function (Panel $panel) {
            //     $panel
            //         ->discoverResources(in: $this->getPluginBasePath('/Filament/Customer/Resources'), for: 'Catalyst\\PrivateCredit\\Filament\\Customer\\Resources')
            //         ->discoverPages(in: $this->getPluginBasePath('/Filament/Customer/Pages'), for: 'Catalyst\\PrivateCredit\\Filament\\Customer\\Pages')
            //         ->discoverClusters(in: $this->getPluginBasePath('/Filament/Customer/Clusters'), for: 'Catalyst\\PrivateCredit\\Filament\\Customer\\Clusters')
            //         ->discoverClusters(in: $this->getPluginBasePath('/Filament/Customer/Widgets'), for: 'Catalyst\\PrivateCredit\\Filament\\Customer\\Widgets');
            // })
            ->when($panel->getId() == 'admin', function (Panel $panel) {
                $panel
                    ->discoverResources(in: $this->getPluginBasePath('/Filament/Admin/Resources'), for: 'Catalyst\\PrivateCredit\\Filament\\Admin\\Resources')
                    ->discoverPages(in: $this->getPluginBasePath('/Filament/Admin/Pages'), for: 'Catalyst\\PrivateCredit\\Filament\\Admin\\Pages')
                    ->discoverClusters(in: $this->getPluginBasePath('/Filament/Admin/Clusters'), for: 'Catalyst\\PrivateCredit\\Filament\\Admin\\Clusters')
                    ->discoverWidgets(in: $this->getPluginBasePath('/Filament/Admin/Widgets'), for: 'Catalyst\\PrivateCredit\\Filament\\Admin\\Widgets');
            });
    }

    public function boot(Panel $panel): void
    {
        //
    }

    protected function getPluginBasePath($path = null): string
    {
        $reflector = new \ReflectionClass(get_class($this));
        return dirname($reflector->getFileName()) . ($path ?? '');
    }
}
