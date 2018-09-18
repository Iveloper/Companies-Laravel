<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use DB;

class RolesModel {

    public function getRoles() {
        return DB::table('roles')
                        ->get();
    }

    public function getPermissions($id) {

        $allPermissions = DB::table('permissions')
                ->leftjoin('permission_group AS pg', 'permissions.permission_group_id', '=', 'pg.id')
                ->select('permissions.name', 'permissions.id', 'pg.name AS permission_group')
                ->orderBy('pg.position')
                ->get();
        
        
        $rolePermissions = DB::table('permission_role as pr')
                ->select('pr.permission_id', 'pr.role_id')
                ->where('pr.role_id', $id)
                ->get();

        for ($i = 0; $i < count($rolePermissions); $i++) {
            $rolePermissions[$i] = $rolePermissions[$i]->permission_id;
        }

        $ready = array_map(
                function($value) {
            return (int) $value;
        }, $rolePermissions
        );

        return[
            'allPermissions' => $allPermissions,
            'rolePermissionFlat' => $ready
        ];
    }

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

    public function getRoleName($id) {
        return DB::table('roles')
                        ->select('roles.name', 'roles.id')
                        ->where('roles.id', $id)
                        ->get();
    }

}
