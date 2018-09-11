<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserModel extends Model {

    protected $table = 'users';
    public $timestamps = false;
    public $order = 'ASC';
    public $sort;
    public $page = 1;
    public $perPage = 5;

    //TO DO: add commments ...
    public function getUsers($request) {

        $query = DB::table('users');

        if ($request->get('searchUser')) {
            $query->where([
                ['username', 'LIKE', '%' . $request->get('searchUser')['username'] . '%']
            ]);
        }

        $sortParam = $request->get('sort', 'id');
        //$sort = $query->orderBy($sortParam, $this->order)->get();
        if ($request->get('sort')) {
            if ($request->get('order') && $request->get('order') == 'ASC') {
                $this->order = 'DESC';
                $this->sort = $query->orderBy($sortParam, $this->order)->get();
            } else {
                $this->order = 'ASC';
                $this->sort = $query->orderBy($sortParam, $this->order)->get();
            }
        }

        if ($request->get('option')) {
            $this->perPage = $request->get('option');
        }

        $totalRows = $query->get();
        return [
            'users' => $query->paginate($this->perPage),
            'sort' => $this->sort,
            'order' => $this->order,
            'perPage' => $this->perPage,
            'total' => $totalRows
        ];
    }

    //TO DO: add commments ...
    public function addUser($data) {

        $data = request()->except(['_token']);
        $data['password'] = bcrypt($data['password']);
        //TO DO: new line ...
        $insert = DB::table('users')->insert([
            ['email' => $data['email'], 'username' => $data['username'], 'password' => $data['password'], 'active' => $data['active'], 'language_id' => $data['language_id']]
        ]);
        Controller::FlashMessages('The user has been added', 'success');
        return $insert;
    }

    //TO DO: add commments ...
    public function updateUser($data) {
        if (isset($data['id']) && $data['id']) {
            $update = DB::table('users')
                    ->where('id', $data['id'])
                    ->update(['username' => $data['username'],
                'email' => $data['email'],
                'active' => $data['active'],
                'language_id' => $data['language_id']
            ]);
            Controller::FlashMessages('The user has been updated', 'success');
            return $update;
        }
    }

    //TO DO: add commments ...
    public function record($id) {
        //TO DO: $view
        $view = DB::table('users')->where('id', '=', $id)->select('id', 'email', 'username', 'active', 'language_id')->get();
        return $view;
    }

    //TO DO: add commments ...
    public function uploadAvatar($id, $data) {

        $fileName = $data->file('avatar')->getClientOriginalName();
        $update = DB::table('users')
                ->where('id', $id)
                ->update(['avatar' => $fileName
        ]);
        Controller::FlashMessages('The avatar has been uploaded', 'success');
        return $update;
    }

    //TO DO: add commments ...
    public function activateUser($id) {
        $query = DB::table('users')->where('id', $id)->update(['active' => 1]);
        Controller::FlashMessages('The user has been activated', 'success');
        return $query;
    }

    //TO DO: add commments ...
    public function deactivateUser($id) {
        $query = DB::table('users')->where('id', $id)->update(['active' => 0]);
        Controller::FlashMessages('The user has been deactivated', 'danger');
        return $query;
    }

    //TO DO: add commments ...
    public function getUserAvatarDirectory() {
        return '/uploads/avatars/' . \Auth::user()->username;
    }
    
    //TO DO: add commments ...
    public static function getLanguage() {
        $query = DB::table('languages')
                ->select('*')
                ->where('active', '=', '1')
                ->get();
        return $query;
    }
    
    //TO DO: add commments ...
    public function getUserPreferredLanguage(){
        //TO DO: $query
        $query = DB::table('users')
                ->select('language_id')
                ->where('id', '=', Auth::user()->id);
        return $query;
    }
}
