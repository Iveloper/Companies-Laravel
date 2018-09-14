<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Company;
use App\Models\Permission;

class CompanyPolicy {

    use HandlesAuthorization;

    public function __construct() {
        //
    }

    public function before(User $user, $ability) {
        if ($user->isSuperAdmin() == '1') {
            return true;
        }
    }

    public function getPermission($permission) {
        return Permission::with('roles')->where('name', $permission)->first();
    }

    public function create(User $user, Company $company) {
        $permission = $this->getPermission('company_create');
        return $user->hasRole($permission);
    }

    public function show(User $user, Company $company) {
        $permission = $this->getPermission('company_show');

        return $user->hasRole($permission);
    }

    public function edit(User $user, Company $company) {

        $permission = $this->getPermission('company_edit');

        return $user->hasRole($permission);
    }

    public function delete(User $user, Company $company) {
        $permission = $this->getPermission('company_delete');

        return $user->hasRole($permission);
    }

}
