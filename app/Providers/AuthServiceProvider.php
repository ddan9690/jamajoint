<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('admin', function ($user) {
            return in_array($user->role, ['admin', 'super']);
        });

        Gate::define('super', function ($user) {
            return $user->role === 'super';
        });

        Gate::define('view-school', function ($user, $school) {

            return $user->role === 'admin' || $user->role === 'super' || $school->id === $user->school_id;
        });
    }
}
