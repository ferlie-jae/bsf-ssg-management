<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Blade::directive('permission', function ($permission) {
            return "<?php if (auth()->user()->can($permission)): ?>";
        });

        Blade::directive('endpermission', function () {
            return "<?php endif; ?>";
        });

        Blade::directive('fa', function($icon) {
            return "<i class=$icon></i>";
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
