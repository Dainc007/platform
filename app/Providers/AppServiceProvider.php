<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

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
        $isProduction = App::isProduction();
        Model::shouldBeStrict($isProduction);
        DB::prohibitDestructiveCommands($isProduction);
        URL::forceScheme('https');

        Gate::define('viewPulse', function (User $user) {
            return $user->isAdmin();
        });
    }
}
