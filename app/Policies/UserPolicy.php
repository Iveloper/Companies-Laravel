<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\Permission;

class UserPolicy {

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

    public function create(User $user, $model) {
        $permission = $this->getPermission('user_create');
        return $user->hasRole($permission);
    }

    public function activate(User $user, $model) {
        $permission = $this->getPermission('user_activate');
        return $user->hasRole($permission);
    }

    public function deactivate(User $user, $model) {
        $permission = $this->getPermission('user_deactivate');

        return $user->hasRole($permission);
    }

    public function edit(User $user, $model) {

        $permission = $this->getPermission('user_edit');

        return $user->hasRole($permission);
    }

    public function upload(User $user, $model) {
        $permission = $this->getPermission('user_upload');

        return $user->hasRole($permission);
    }

}
