<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Role;

class RolesModel {

    public function getRoles() {
        return DB::table('roles')
                        ->get();
    }

    public function getPermissions($id) {

        $allPermissions = DB::table('permissions')
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

//        $user = DB::table('permission_role as pr')
//                ->select('pr.permission_id', 'pr.role_id')
//                ->where('pr.role_id', 2)
//                ->get();
//
//        for ($i = 0; $i < count($user); $i++) {
//            $user[$i] = $user[$i]->permission_id;
//        }
//        
//        $newArray = array_map(
//                function($value) {
//            return (int) $value;
//        }, $user
//        );

        return[
            'allPermissions' => $allPermissions,
            'rolePermissionFlat' => $ready
        ];
    }

    public function manageUsers($data) {
        DB::table('permission_role')
                ->where('role_id', $data['role_id'])
                ->delete();

        //  https://laravel.com/docs/5.2/queries#inserts

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
