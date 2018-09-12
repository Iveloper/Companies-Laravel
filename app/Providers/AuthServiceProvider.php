<?php

namespace App\Providers;

use App\Models\Permission;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Gate;
use Illuminate\Support\Facades\Auth;

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

   
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

        $permissions = Permission::with('roles')->get();
        
        foreach ($permissions as $permission){
            $gate->define($permission->name, function($user) use ($permission){
               return $user->hasRole($permission);
            });
        }
    }
}
