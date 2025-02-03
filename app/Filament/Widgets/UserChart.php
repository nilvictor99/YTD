<?php

namespace App\Filament\Widgets;

use EightyNine\FilamentAdvancedWidget\AdvancedChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class UserChart extends AdvancedChartWidget
{
    protected static ?string $heading = 'Usuarios';  // Will be populated dynamically
    protected static string $color = 'info';
    protected static ?string $icon = 'heroicon-o-users';
    protected static ?string $iconColor = 'info';
    protected static ?string $iconBackgroundColor = 'info';
    protected static ?string $label = 'Usuarios registrados';

    protected static ?string $badge = '';
    protected static ?string $badgeColor = 'success';
    protected static ?string $badgeIcon = 'heroicon-o-user-plus';
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
        $users = \App\Models\User::select('created_at')
            ->get()
            ->groupBy(function ($user) {
                return $user->created_at->format('M');
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

        $userData = $months->map(function ($month) use ($users) {
            return $users->get($month)?->count() ?? 0;
        });

        return [
            'datasets' => [
                [
                    'label' => __('Users registered'),
                    'data' => $userData->values()->toArray(),
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
