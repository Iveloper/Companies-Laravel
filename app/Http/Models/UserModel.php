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
use Illuminate\Support\Facades\Storage;

class UserModel extends Model {

    protected $table = 'users';
    public $timestamps = false;
    public $order = 'ASC';
    public $sort;
    public $page = 1;
    public $perPage = 5;

    //Shows a list of all the users from database.
    public function getUsers($request) {
        $query = DB::table('users');

        if ($request->get('searchUser')) {
            $query->where([
                ['username', 'LIKE', '%' . $request->get('searchUser')['username'] . '%']
            ]);
        }

        $sortParam = $request->get('sort', 'id');
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

    //Adds new user with bcrypt hashed password to the database.
    public function addUser($data) {

        $data = request()->except(['_token']);
        Controller::FlashMessages('The user has been added', 'success');
        return $insert = DB::table('users')->insert([
            ['email' => $data['email'],
                'username' => $data['username'],
                'password' => bcrypt($data['password']),
                'active' => $data['active'],
                'language_id' => $data['language_id']]
        ]);
    }

    //Updates the information about a specific user.
    public function updateUser($data) {

        Controller::FlashMessages('The user has been updated', 'success');
        return DB::table('users')
                        ->where('id', $data['id'])
                        ->update(['username' => $data['username'],
                            'email' => $data['email'],
                            'active' => $data['active'],
                            'language_id' => $data['language_id']
        ]);
    }

    //Shows every piece of information about an user by given id.
    public function record($id) {
        return DB::table('users')
                        ->where('id', '=', $id)
                        ->select('id', 'email', 'username', 'active', 'language_id')
                        ->get();
    }

    //Makes a new directory named after the user's username and stores all of his avatars there.
    public function uploadAvatar($id, $data) {
        $path = $this->getUserAvatarDirectory();

        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }
        Storage::put(
                $path . DIRECTORY_SEPARATOR . $data->file('avatar')->getClientOriginalName(), file_get_contents($data->file('avatar')->getRealPath())
        );
        $fileName = $data->file('avatar')->getClientOriginalName();

        Controller::FlashMessages('The avatar has been uploaded', 'success');

        return DB::table('users')
                        ->where('id', $id)
                        ->update(['avatar' => $fileName
        ]);
    }

    //Activates an user.
    public function activateUser($id) {
        Controller::FlashMessages('The user has been activated', 'success');

        return DB::table('users')
                        ->where('id', $id)
                        ->update(['active' => 1]);
    }

    //Deactivates an user.
    public function deactivateUser($id) {
        Controller::FlashMessages('The user has been deactivated', 'danger');

        return DB::table('users')
                        ->where('id', $id)
                        ->update(['active' => 0]);
    }

    //Returns the main directory where all the avatars will be stored.
    public function getUserAvatarDirectory() {
        return '/uploads/avatars/' . \Auth::user()->username;
    }

    //Selects all active languages from the database
    public static function getLanguage() {
        return DB::table('languages')
                        ->select('*')
                        ->where('active', '=', '1')
                        ->get();
    }

    //Selects the preferred language for the user logged in our system.
    public function getUserPreferredLanguage() {
        return DB::table('users')
                        ->select('language_id')
                        ->where('id', '=', Auth::user()->id);
    }

}
