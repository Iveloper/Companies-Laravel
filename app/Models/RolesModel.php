<?php

namespace App\Models;

use DB;

class RolesModel {

    //Gets all pieces of information from 'roles' table.
    public function getRoles() {
        return DB::table('roles')
                        ->get();
    }

    //Selects all permissions from 'permissions' table and orders them by the position of ther 'permission_group_id' row.
    public function getPermissions($id) {
        $allPermissions = DB::table('permissions')
                ->leftjoin('permission_group AS pg', 'permissions.permission_group_id', '=', 'pg.id')
                ->select('permissions.name', 'permissions.id', 'pg.name AS permission_group')
                ->orderBy('pg.position')
                ->get();

        $rolePermissions = DB::table('permission_role as pr')
                ->where('pr.role_id', $id)
                ->pluck('permission_id');

        return [
            'allPermissions' => $this->transformPermissions($allPermissions),
            'rolePermissions' => $rolePermissions
        ];
    }

    //Stores all permissions in a collection and groups them by permission_group
    protected function transformPermissions($allPermissions) {
        $collection = collect($allPermissions);
        return $collection->groupBy('permission_group')->toArray();
    }

    /* This function does all the magic with the roles and their permissions
     * When the selected checkboxes send information about the permissions for
     * a specific role, this piece of code deletes everything from the 'permission_role'
     * table and inserts new permissions for a specific role.
     */
    public function manageUsers($data) {
        DB::table('permission_role')
                ->where('role_id', $data['role_id'])
                ->delete();

        $rows = [];

        foreach ($data['permissionForAdmin'] as $permission_id) {
            array_push($rows, [
                'permission_id' => $permission_id,
                'role_id' => $data['role_id']
            ]);
        }

        return DB::table('permission_role')
                        ->insert($rows);
    }

    //A function that returns name of the role for a user by his id.
    public function getRoleName($id) {
        return DB::table('roles')
                        ->select('roles.name', 'roles.id')
                        ->where('roles.id', $id)
                        ->get();
    }

}
