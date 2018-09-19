<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\PersonModel;
use App\Models\Permission;

class PersonPolicy {

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

    //Gives permission to create new person.
    public function create(User $user, PersonModel $person) {
        $permission = $this->getPermission('person_create');

        return $user->hasRole($permission);
    }

    //Gives permission to show specific person.
    public function show(User $user, PersonModel $person) {
        $permission = $this->getPermission('person_show');

        return $user->hasRole($permission);
    }
    
    //Gives permission to edit concrete person.
    public function edit(User $user, PersonModel $person) {
        $permission = $this->getPermission('person_edit');

        return $user->hasRole($permission);
    }
    
    //Gives permission to delete specific person.
    public function delete(User $user, PersonModel $person) {
        $permission = $this->getPermission('person_delete');

        return $user->hasRole($permission);
    }

}
