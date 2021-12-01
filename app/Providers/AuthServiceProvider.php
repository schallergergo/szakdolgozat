<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Models\Program' => 'App\Policies\ProgramPolicy',
         'App\Models\Result' => 'App\Policies\ResultPolicy',
         'App\Models\User' => 'App\Policies\UserPolicy',
         'App\Models\Program' => 'App\Policies\ProgramPolicy',
         'App\Models\Block' => 'App\Policies\BlockPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
