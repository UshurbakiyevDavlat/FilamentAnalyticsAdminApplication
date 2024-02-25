<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use App\Models\PostView;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    /**
     * Polling interval for the widget.
     *
     * @var string|null
     */
    protected static ?string $pollingInterval = '10s';

    /**
     * The getStats method is called every time the widget is polled.
     *
     * @return array
     */
    protected function getStats(): array
    {
        $adminsAmount = User::with('roles')->get()->filter(
            fn($user) => $user->roles->whereIn('id', [1, 2])->toArray(),
        )
            ->count();

        $usersAmount = User::count();
        $postsAmount = Post::count();

        $likeActivityLastWeek = Post::all()
            ->whereBetween(
                'created_at',
                [now()->subWeek(), now()],
            )
            ->sum('likes_count');

        $bookmarkActivityLastWeek = Post::all()
            ->whereBetween(
                'created_at',
                [now()->subWeek(), now()],
            )
            ->sum('bookmarks_count');

        $viewsActivityLastWeek = PostView::all()
            ->whereBetween(
                'created_at',
                [now()->subWeek(), now()],
            )
            ->count();

        return [
            Stat::make(__('stats_overview.admins_amount'), $adminsAmount),
            Stat::make(__('stats_overview.users_amount'), $usersAmount),
            Stat::make(__('stats_overview.posts_amount'), $postsAmount),
            Stat::make(__('stats_overview.views_activity_last_week'), $viewsActivityLastWeek),
            Stat::make(__('stats_overview.likes_activity_last_week'), $likeActivityLastWeek),
            Stat::make(__('stats_overview.bookmarks_activity_last_week'), $bookmarkActivityLastWeek),
        ];
    }
}
