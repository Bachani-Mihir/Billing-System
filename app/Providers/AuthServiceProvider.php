<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
        $this->registerPolicies();

        Gate::define('role', function ($ExpectedRole) {
            return Auth::user()->role == $ExpectedRole;
        });

        Gate::define('isInvoiceOwner', function ($user, $invoice) {
            return ($user->isAn('employee') || $user->isAn('admin')) && ($user->user_id == $invoice->employee_id);
        });
    }
}
