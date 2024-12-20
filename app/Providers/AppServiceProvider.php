<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\User;
use App\Policies\Admin\SettingPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
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
        $this->registerPolicies();
        $this->logMissingTranslationKeys();
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
        if ($this->app->environment('production')) {
            Gate::before(function ($user, $ability) {
                return $user->hasRole(config('permission.default_role'));
            });
        }

        Gate::define('viewPulse', function (User $user) {
            return $user->isAdmin();
        });
    }

    private function registerPolicies(): void
    {
        Gate::policy(Setting::class, SettingPolicy::class);
    }

    private function logMissingTranslationKeys(): void
    {
        Lang::handleMissingKeysUsing(function ($key, $replace, $locale, $fallback) {
           Log::error("Missing translation key: {$key} in locale: {$locale}");
        });
    }
}
