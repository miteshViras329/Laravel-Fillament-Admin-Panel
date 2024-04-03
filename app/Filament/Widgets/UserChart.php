<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class UserChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $year = date('Y');
        $userCountByMonth = User::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get()->pluck('total', 'month')->toArray();

        $result = [];
        foreach (range(1, 12) as $res) {
            if (empty($userCountByMonth[$res])) {
                $result[$res] = 0;
            } else {
                $result[$res] = $userCountByMonth[$res];
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'New User',
                    'data' => array_values($result),
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
