<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\UserModel;
use App\Http\Requests\StoreUserPost;


class UserController extends Controller {

    public $model;

    public function __construct(UserModel $model) {
        $this->model = $model;
    }

    public function index(Request $request) {
        $users = $this->model->getUsers($request);
        return view('/users/list')->with('users', $users);
    }

    public function show() {
        $view = $this->model->record($id);
        return view('persons/record', compact('view'));
    }

    public function create() {
        return view('users/add');
    }

    public function update($id, Request $request) {
        $this->model->updateUser($request->all());
        return redirect('/users');
    }

    public function store(Request $request, StoreUserPost $user) {
        $add = $this->model->addUser($request->all());
        return redirect('/users');
    }

    public function edit($id) {
        $edit = $this->model->record($id);
        return view('/users/edit', compact('edit'));
    }

    public function activate($id) {
        $activate = $this->model->activateUser($id);
        return redirect('/users');
    }

    public function deactivate($id) {
        $delete = $this->model->deactivateUser($id);

        return redirect('/users');
    }

    public function upload($id) {
        $upload = $this->model->record($id);

        return view('/users/upload', compact('upload'));
    }

    public function file($id, Request $request) {
        if ($request->hasFile('avatar')) {
            $request->file('avatar')->move(public_path() . '/uploads/avatars', $request->file('avatar')->getClientOriginalName());
            $this->model->uploadAvatar($id, $request);
            return redirect('/users');
        }
    }

}
