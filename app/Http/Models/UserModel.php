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

class UserModel extends Model {

    protected $table = 'users';
    public $timestamps = false;
    public $order = 'ASC';
    public $sort;
    public $page = 1;
    public $perPage = 5;

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

    public function addUser($data) {

        $data = request()->except(['_token']);
        $data['password'] = bcrypt($data['password']);
        $insert = DB::table('users')->insert([
            ['email' => $data['email'], 'username' => $data['username'], 'password' => $data['password'], 'active' => $data['active']]
        ]);
        Controller::FlashMessages('The user has been added', 'success');
        return $insert;
    }

    public function updateUser($data) {
        if (isset($data['id']) && $data['id']) {
            $update = DB::table('users')
                    ->where('id', $data['id'])
                    ->update(['username' => $data['username'],
                'email' => $data['email'],
                'active' => $data['active']
            ]);
            Controller::FlashMessages('The user has been updated', 'success');
            return $update;
        }
    }

    public function record($id) {
        $view = DB::table('users')->where('id', '=', $id)->select('id', 'email', 'username', 'active')->get();
        return $view;
    }

    public function uploadAvatar($id, $data) {

        $fileName = $data->file('avatar')->getClientOriginalName();
        $update = DB::table('users')
                ->where('id', $id)
                ->update(['avatar' => $fileName
        ]);
        Controller::FlashMessages('The avatar has been uploaded', 'success');
        return $update;
    }

    public function activateUser($id) {
        $query = DB::table('users')->where('id', $id)->update(['active' => 1]);
        Controller::FlashMessages('The user has been activated', 'success');
        return $query;
    }

    public function deactivateUser($id) {
        $query = DB::table('users')->where('id', $id)->update(['active' => 0]);
        Controller::FlashMessages('The user has been deactivated', 'danger');
        return $query;
    }

    public function getUserAvatarDirectory() {
        return '/uploads/avatars/' . \Auth::user()->username;
    }
}
