<?php

namespace App\Providers;

use App\Models\Category_type;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use View;

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
        Schema::defaultStringLength(191);
        View::composer('*', function ($view) {
            $navitem = Category_type::where('display', 1)->orderBy('name', 'asc')->get();
            $view->with('navitem', $navitem);
        });
    }
}
