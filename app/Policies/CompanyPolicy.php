<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Company;
use App\Models\Permission;

class CompanyPolicy {

    use HandlesAuthorization;

    public function __construct() {
        
    }
    
    /*This function will execute before any other and if it returns something
     * different than true,anything else from the class will be skipped.
    */
    public function before(User $user, $ability) {
        if ($user->isSuperAdmin() == '1') {
            return true;
        }
    }
    
    //Finds the specific permission for the role of the logged user.
    public function getPermission($permission) {
        return Permission::with('roles')->where('name', $permission)->first();
    }

    //Gives permission to create new company.
    public function create(User $user, Company $company) {
        $permission = $this->getPermission('company_create');
        return $user->hasRole($permission);
    }
    
    //Gives permission to show a specific company.
    public function show(User $user, Company $company) {
        $permission = $this->getPermission('company_show');

        return $user->hasRole($permission);
    }
    
    //Gives permission to edit concrete company.
    public function edit(User $user, Company $company) {
        $permission = $this->getPermission('company_edit');

        return $user->hasRole($permission);
    }

    //Gives permission to delete a company.
    public function delete(User $user, Company $company) {
        $permission = $this->getPermission('company_delete');

        return $user->hasRole($permission);
    }

}
