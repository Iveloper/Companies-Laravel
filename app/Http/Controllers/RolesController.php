<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use App\Models\RolesModel;

/**
 * Description of RolesController
 *
 * @author ivelin
 */
class RolesController extends Controller{
    
    public $model;

    public function __construct(RolesModel $model) {
        $this->model = $model;
    }
    
    //TO DO: podredi me ...
        public function roles(){
            $roles = $this->model->getRoles();
            return view('users/roles', compact('roles'));
        }
        public function permission($id){
        $this->authorize('manage', User::class);
        $permissions = $this->model->getPermissions($id);
        
        $roleName = $this->model->getRoleName($id);
        return view('users/manage', compact('permissions', 'roleName'));
    }
    
    public function manage(Request $request){
        $this->authorize('manage', User::class);
        $this->model->manageUsers($request->all());
        return redirect('/users');
    }
    
}
