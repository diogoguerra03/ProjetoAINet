<?php

namespace App\Providers;

use App\Models\TshirtImage;
use App\Policies\TshirtImagePolicy;
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
        // TshirtImage::class => TshirtImagePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        /*Gate::define('administrar', function (User $user) {
            return $user->admin;
        });
        Gate::define('access-cart', function (User $user) {
            return $user->user_type === 'A';
        });*/
    }
}