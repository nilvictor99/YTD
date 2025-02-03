<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Downloader extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-arrow-down-tray';

    protected static string $view = 'filament.pages.downloader';

    public function getTitle(): string|Htmlable
    {
        return __('downloader.downloader');
    }

    public static function getNavigationLabel(): string
    {
        return __('downloader.MediaGrabber');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('navigation-panel.Tools');
    }


}
