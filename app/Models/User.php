<?php

namespace App\Models;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {

    protected $table = 'users';
    public $timestamps = false;
    public $order = 'ASC';
    public $sort;
    public $page = 1;
    public $perPage = 5;

    public function isSuperAdmin() {
        $query = DB::table('users')
                ->join('role_user', 'user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('role_user.role_id AS role', 'roles.name AS role')
                ->where('users.id', '=', Auth::user()->id)
                ->get();

        return $query[0]->role;
    }

    public function hasRole($permission) {
        return !!$this->roles->intersect($permission->roles)->count();
    }

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    //Shows a list of all the users from database.
    public function getUsers($request) {
        $query = DB::table('users')
                ->join('role_user', 'user_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'role_user.role_id')
                ->select('users.*', 'roles.name AS role');

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
        DB::beginTransaction();
            DB::table('users')
                    ->where('users.id', $data['id'])
                    ->update(['username' => $data['username'],
                        'email' => $data['email'],
                        'active' => $data['active'],
                        'language_id' => $data['language_id']
            ]);
            
            DB::table('role_user AS ru')
                    ->leftjoin('users', 'users.id', '=', 'user_id')
                    ->where('id', $data['id'])
                    ->update([
                        'ru.role_id' => $data['role']
                    ]);
        DB::commit();

        
//        return DB::table('users AS u')
//                        ->join('role_user AS ru', 'user_id', '=', 'users.id')
//                        ->where('users.id', $data['id'])
//                        ->update(['u.username' => $data['username'],
//                            'u.email' => $data['email'],
//                            'u.active' => $data['active'],
//                            'u.language_id' => $data['language_id'],
//                            'ru.role_id' => $data['role']
//        ]);
    }

    public function getRole() {
        return DB::table('roles')
                        
                        ->select('roles.name AS roles', 'roles.id AS roles_id')
                        ->get();
    }

    public function getAllPermissions(){
        return DB::table('permissions')
                ->select('permissions.name', 'permissions.id')
                ->get();
    }
    
    //Shows every piece of information about an user by given id.
    public function record($id) {
        return DB::table('users')
                        ->join('role_user', 'user_id', '=', 'users.id')
                        ->join('roles', 'roles.id', '=', 'role_user.role_id')
                        ->where('users.id', $id)
                        ->select('users.*', 'roles.name AS role')
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
