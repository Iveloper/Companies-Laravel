<?php

namespace App\Providers;

use App\Policies\CompanyPolicy;
use App\Policies\PersonPolicy;
use App\Policies\UserPolicy;
use App\Models\User;
use App\Models\Company;
use App\Models\PersonModel;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {

    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Company::class => CompanyPolicy::class,
        PersonModel::class => PersonPolicy::class,
        User::class => UserPolicy::class,
    ];

    public function boot(GateContract $gate) {
        $this->registerPolicies($gate);
    }
    

}
