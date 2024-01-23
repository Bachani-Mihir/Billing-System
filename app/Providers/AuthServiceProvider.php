<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Invoice;
use App\Models\User;
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

        Gate::define('role', function ($user,$role) {
            return $user->role === $role;
        });

        Gate::define('isInvoiceOwner', function ($invoice) {
            return (Auth::user()->role === 'employee' && (Auth::user()->user_id == $invoice->user_id));
        });
    }
}
