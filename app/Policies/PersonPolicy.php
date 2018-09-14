<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\User;
use App\Models\PersonModel;
use App\Models\Permission;

class PersonPolicy {

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

    public function create(User $user, PersonModel $person) {
        $permission = $this->getPermission('person_create');

        return $user->hasRole($permission);
    }

    public function show(User $user, PersonModel $person) {
        $permission = $this->getPermission('person_show');

        return $user->hasRole($permission);
    }

    public function edit(User $user, PersonModel $person) {

        $permission = $this->getPermission('person_edit');

        return $user->hasRole($permission);
    }

    public function delete(User $user, PersonModel $person) {
        $permission = $this->getPermission('person_delete');

        return $user->hasRole($permission);
    }

}
