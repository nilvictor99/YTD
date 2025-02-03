<?php

namespace App\Filament\Widgets;

use EightyNine\FilamentAdvancedWidget\AdvancedChartWidget;
class DownloadChart extends AdvancedChartWidget
{
    protected static ?string $heading = 'Descargas';
    protected static string $color = 'info';
    protected static ?string $icon = 'heroicon-o-arrow-down-circle';
    protected static ?string $iconColor = 'info';
    protected static ?string $iconBackgroundColor = 'info';
    protected static ?string $label = 'Descargas';

    protected static ?string $badge = '';
    protected static ?string $badgeColor = 'success';
    protected static ?string $badgeIcon = 'heroicon-o-arrow-down';
    protected static ?string $badgeIconPosition = 'after';
    protected static ?string $badgeSize = 'xs';

    public ?string $filter = 'today';

    protected function getFilters(): ?array
    {
        return [
            'today' => __('Today'),
            'week' => __('Last week'),
            'month' => __('Last month'),
            'year' => __('This year'),
        ];
    }

    protected function getData(): array
    {
        $downloads = \App\Models\Download::select('created_at')
            ->get()
            ->groupBy(function ($download) {
                return $download->created_at->format('M');
            });

        $months = collect([
            __('Jan'),
            __('Feb'),
            __('Mar'),
            __('Apr'),
            __('May'),
            __('Jun'),
            __('Jul'),
            __('Aug'),
            __('Sep'),
            __('Oct'),
            __('Nov'),
            __('Dec')
        ]);

        $downloadData = $months->map(function ($month) use ($downloads) {
            return $downloads->get($month)?->count() ?? 0;
        });

        return [
            'datasets' => [
                [
                    'label' => __('Downloads'),
                    'data' => $downloadData->values()->toArray(),
                ],
            ],
            'labels' => $months->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
