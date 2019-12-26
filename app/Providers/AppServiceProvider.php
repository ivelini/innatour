<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Tour;
use App\Observers\CategoryObserver;
use App\Observers\TourObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Tour::observe(TourObserver::class);
        Category::observe(CategoryObserver::class);
    }
}
