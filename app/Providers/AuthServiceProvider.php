<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Tour;
use App\Policies\CategoryPolicy;
use App\Policies\TourPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Tour::class => TourPolicy::class,
        Category::class => CategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('authManager', 'App\Policies\AuthPolicy@authManager');
        Gate::define('authAdmin', 'App\Policies\AuthPolicy@authAdmin');

        //
    }
}
