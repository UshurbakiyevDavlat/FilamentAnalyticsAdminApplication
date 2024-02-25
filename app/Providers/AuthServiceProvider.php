<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        'Spatie\Permission\Models\Role' => 'App\Policies\RolePolicy',
        'Spatie\Permission\Models\Permission' => 'App\Policies\PermissionPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\TypePaper' => 'App\Policies\TypePaperPolicy',
        'App\Models\Ticker' => 'App\Policies\TickerPolicy',
        'App\Models\Tag' => 'App\Policies\TagPolicy',
        'App\Models\Subscription' => 'App\Policies\SubscriptionPolicy',
        'App\Models\Status' => 'App\Policies\StatusPolicy',
        'App\Models\Sector' => 'App\Policies\SectorPolicy',
        'App\Models\PostView' => 'App\Policies\PostViewPolicy',
        'App\Models\PostType' => 'App\Policies\PostTypePolicy',
        'App\Models\PostTranslation' => 'App\Policies\PostTranslationPolicy',
        'App\Models\Post' => 'App\Policies\PostPolicy',
        'App\Models\Locale' => 'App\Policies\LocalePolicy',
        'App\Models\Like' => 'App\Policies\LikePolicy',
        'App\Models\Isin' => 'App\Policies\IsinPolicy',
        'App\Models\HorizonDataset' => 'App\Policies\HorizonDatasetPolicy',
        'App\Models\FileType' => 'App\Policies\FileTypePolicy',
        'App\Models\File' => 'App\Policies\FilePolicy',
        'App\Models\Favourite' => 'App\Policies\FavouritePolicy',
        'App\Models\Ecosystem' => 'App\Policies\EcosystemPolicy',
        'App\Models\Country' => 'App\Policies\CountryPolicy',
        'App\Models\Category' => 'App\Policies\CategoryPolicy',
        'App\Models\CategoryTranslation' => 'App\Policies\CategoryTranslationPolicy',
        'App\Models\Action' => 'App\Policies\ActionPolicy',
        'App\Models\ActionHistory' => 'App\Policies\ActionHistoryPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::before(function (User $user, string $ability) {
            return $user->isSuperAdmin() ? true : null;
        });

        $this->registerPolicies();

        if (config('app.env') !== 'local') {
            Gate::define('viewPulse', function ($user) {
                return $user->hasRole('Super Admin');
            });
        }
    }
}
