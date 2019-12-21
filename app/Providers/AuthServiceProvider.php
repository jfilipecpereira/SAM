<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use App\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::routes();

        Gate::define('superUser', 'App\Policies\Users@superUser');
        Gate::define('direcao', 'App\Policies\Users@Direcao');
        Gate::define('secretaria', 'App\Policies\Users@Secretaria');
        Gate::define('Aluno', 'App\Policies\Users@Aluno');


    }
}
