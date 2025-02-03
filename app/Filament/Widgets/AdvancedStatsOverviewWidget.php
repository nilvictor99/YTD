<?php

namespace App\Filament\Widgets;

use App\Models\Download;
use App\Models\User;
use EightyNine\FilamentAdvancedWidget\AdvancedStatsOverviewWidget as BaseWidget;
use EightyNine\FilamentAdvancedWidget\AdvancedStatsOverviewWidget\Stat;
use Filament\Support\Enums\IconPosition;

class AdvancedStatsOverviewWidget extends BaseWidget
{
    protected static ?string $pollingInterval = null;

    protected function getStats(): array
    {
        $user_progress = min(100, (User::count() / 100) * 100);
        $dowload_progress = min(100, (Download::count() / 100) * 100);

        return [
            Stat::make(__('widgets.Total Users'), User::all()->count())->icon('heroicon-o-user')
                ->description(__('widgets.total_users_description'))
                ->backgroundColor('secondary')
                ->progress($user_progress)
                ->progressBarColor('success')
                ->iconBackgroundColor('success')
                ->chartColor('success')
                ->iconPosition('start')
                ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before)
                ->descriptionColor('success')
                ->iconColor('success'),

            Stat::make(__('widgets.Total Dowloads'), Download::all()->count())->icon('heroicon-o-arrow-down-tray')
                ->description(__('widgets.total_dowloads_description'))
                ->progress(progress: $dowload_progress)
                ->progressBarColor('warning')
                ->chartColor('success')
                ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before)
                ->descriptionColor('warning')
                ->iconColor('warning'),

        ];
    }
}