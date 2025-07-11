<?php

namespace Catalyst\PrivateCreditWebsite\Filament\Customer\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Catalyst\PrivateCreditWebsite\Models\Page as PageModel;

class Homepage extends Page
{
    protected static string $routePath = '/';

    protected static ?int $navigationSort = -2;

    /**
     * @var view-string
     */
    protected static string $view = 'private-credit-website::filament.customer.pages.homepage';

    public static function getNavigationLabel(): string
    {
        return 'Home';
    }

    public static function getRoutePath(): string
    {
        return static::$routePath;
    }

    public function getTitle(): string|Htmlable
    {
        return 'Homepage';
    }

    public function getContent(): string|Htmlable
    {
        $homePage = PageModel::where('slug', 'home')->first();

        return $homePage?->content ?? '';
    }
}
