<?php

namespace App\Providers;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->modelPreventActions();
        $this->processGateAdditionalActions();
    }

    /**
     * @return void
     */
    public function modelPreventActions(): void
    {
        Model::preventLazyLoading(!$this->app->isProduction());
        Model::preventSilentlyDiscardingAttributes();
        Model::preventAccessingMissingAttributes();
    }

    /**
     * @return void
     */
    public function processGateAdditionalActions(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole(Role::HeadAdmin);
        });

        Gate::define('viewPulse', function (User $user) {
            return $user->isAdmin();
        });
    }
}
