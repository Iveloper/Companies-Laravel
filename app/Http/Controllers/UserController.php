<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Http\Models\CompanyModel;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Description of UserController
 *
 * @author ivelin
 */
class UserController extends Controller {

    public function index() {
        $company = CompanyModel::all();
        return response()->json($company);
//        $result = CompanyModel::where('name','rger')->get();
        foreach ($company as $r){
            echo $r->name.'<br>';
        }
    }

    public function register_form() {
        return view('register');
    }

    public function register(Request $request) {
        
        $this->validate($request, [
        'username' => 'min:5|max:30|required',
        'password' => 'min:10|required',
        'password2' => 'same:password|required'
        ]);
        
    }

}
