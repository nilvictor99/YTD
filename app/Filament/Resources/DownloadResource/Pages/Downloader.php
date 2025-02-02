<?php

namespace App\Filament\Resources\DownloadResource\Pages;

use App\Filament\Resources\DownloadResource;
use Filament\Resources\Pages\Page;

class Downloader extends Page
{
    protected static string $resource = DownloadResource::class;

    protected static string $view = 'filament.resources.download-resource.pages.downloader';
}
