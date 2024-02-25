<?php

namespace App\Filament\Resources\UserResource\Widgets;

use Filament\Widgets\ChartWidget;

class UserChart extends ChartWidget
{
    /**
     * Heading for the widget.
     *
     * @var string|null
     */
    protected static ?string $heading = 'Users chart';

    /**
     * Get the chart data.
     *
     * @return array
     */
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Users created',
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                ],

                [
                    'label' => 'Users edited',
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                    'data' => [0, 5, 10, 15, 20, 25, 30, 35, 40, 45, 50],
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    /**
     * Get the chart type.
     *
     * @return string
     */
    protected function getType(): string
    {
        return 'line';
    }
}
