<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\{
    Course,
    Request,
    Note,
    IntendedPlan
};
use App\Policies\{
    CoursePolicy,
    RequestPolicy,
    NotePolicy,
    IntendedPlanPolicy
};

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Course::class => CoursePolicy::class,
        Request::class => RequestPolicy::class,
        Note::class => NotePolicy::class,
        IntendedPlan::class => IntendedPlanPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user) {
            if ( $user->isAdmin() ) {
                return true;
            }
        });
    }
}
