<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Permission;

class UserPolicy {

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

    //Gives permission to create new user.
    public function create(User $user, $model) {
        $permission = $this->getPermission('user_create');
        return $user->hasRole($permission);
    }
    
    //Gives permission to activate specific user.
    public function activate(User $user, $model) {
        $permission = $this->getPermission('user_activate');
        return $user->hasRole($permission);
    }

    //Gives permission to deactivate specific user.
    public function deactivate(User $user, $model) {
        $permission = $this->getPermission('user_deactivate');

        return $user->hasRole($permission);
    }    
     
    //Gives permission to edit concrete user.
    public function edit(User $user, $model) {
        $permission = $this->getPermission('user_edit');

        return $user->hasRole($permission);
    }

    //Gives permission to upload an avatar for a user.
    public function upload(User $user, $model) {
        $permission = $this->getPermission('user_upload');

        return $user->hasRole($permission);
    }
    
    //Gives permission to manage permissions for all roles.
    public function manage(User $user, $model) {
        $permission = $this->getPermission('user_manage');

        return $user->hasRole($permission);
    }
}
