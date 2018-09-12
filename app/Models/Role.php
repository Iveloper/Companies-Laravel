<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use App\Models\Permission;

/**
 * Description of Roles
 *
 * @author ivelin
 */
class Role extends \Illuminate\Database\Eloquent\Model{
    
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    
}
