<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Approval;
use App\Models\HelpdeskTicket;
use App\Models\LoanRequest;
use App\Models\User;
use App\Observers\ApprovalObserver;
use App\Observers\HelpdeskTicketObserver;
use App\Observers\LoanRequestObserver;
use App\Observers\UserObserver;
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
        if ($this->app->environment('local') && class_exists(TelescopeServiceProvider::class)) {
            $this->app->register(TelescopeServiceProvider::class);
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

        // Register model observers for memory MCP logging
        User::observe(UserObserver::class);
        LoanRequest::observe(LoanRequestObserver::class);
        HelpdeskTicket::observe(HelpdeskTicketObserver::class);
        Approval::observe(ApprovalObserver::class);
    }
}
