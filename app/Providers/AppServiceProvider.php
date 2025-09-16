<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\HelpdeskTicket;
use App\Models\LoanRequest;
use App\Policies\HelpdeskTicketPolicy;
use App\Policies\LoanRequestPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(\App\Providers\TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register model policies
        Gate::policy(HelpdeskTicket::class, HelpdeskTicketPolicy::class);
        Gate::policy(LoanRequest::class, LoanRequestPolicy::class);
    }
}
