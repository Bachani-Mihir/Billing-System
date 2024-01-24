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

        Gate::define('role', function (User $user, $ExpectedRole) {
            return $user->role === $ExpectedRole && ($user->business_id == request()->business_id);
        });

        Gate::define('isInvoiceOwner', function (User $user , $invoice) {
            return $user->role === 'employee' && ($user->id === $invoice->user_id);
        });

        Gate::define('IsBusinessOwner', function (User $user , $business_id) {
            return $user->role === 'owner' && ($user->business_id == $business_id);
        });
    }
}
