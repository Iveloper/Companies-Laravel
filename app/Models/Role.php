<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Models;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;



class Role extends Model{
    
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
    
}
