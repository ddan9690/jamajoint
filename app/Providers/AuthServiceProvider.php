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

        Gate::define('view-exam', function ($user, $exam) {
            // Super users can see all exams
            if ($user->role === 'super') {
                return true;
            }

            // Check if the user's school is registered for the exam
            return $exam->schools()->where('school_id', $user->school_id)->exists();
        });

    }
}
