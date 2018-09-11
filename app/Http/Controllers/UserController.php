<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\UserModel;
use App\Http\Requests\StoreUserPost;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreFilePost;


class UserController extends Controller {

    public $model;

    public function __construct(UserModel $model) {
        $this->model = $model;
    }

    //TO DO: add commments ...
    public function index(Request $request) {
        $users = $this->model->getUsers($request);
        return view('/users/list')->with('users', $users);
    }

    //TO DO: add commments ...
    public function show() {
        $view = $this->model->record($id);
        return view('persons/record', compact('view'));
    }

    //TO DO: add commments ...
    public function create() {
        $lang = $this->model->getLanguage();
        return view('users/add', compact('lang'));
    }

    //TO DO: add commments ...
    public function update($id, Request $request) {
        if($request->all()['language_id'] == '2'){
            session()->put('language', 'bg');
        }
        else{
            session()->put('language', 'en');
        }
        $this->model->updateUser($request->all());
        return redirect('/users');
    }

    //TO DO: add commments ...
    public function store(Request $request, StoreUserPost $user) {
        $add = $this->model->addUser($request->all());
        return redirect('/users');
    }

    //TO DO: add commments ...
    public function edit($id) {
        $edit = $this->model->record($id);
        $lang = $this->model->getLanguage();
        return view('/users/edit', compact('edit', 'lang'));
    }

    //TO DO: add commments ...
    public function activate($id) {
        $activate = $this->model->activateUser($id);
        return redirect('/users');
    }

    //TO DO: add commments ...
    public function deactivate($id) {
        $delete = $this->model->deactivateUser($id);

        return redirect('/users');
    }

    //TO DO: add commments ...
    public function upload($id) {
        $upload = $this->model->record($id);

        return view('/users/upload', compact('upload'));
    }

    //TO DO: add commments ...
    public function file($id, Request $request, StoreFilePost $file) {
        $path = $this->model->getUserAvatarDirectory();

        //TO DO: move logic to model
        if(!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }
        
        Storage::put(
            $path . DIRECTORY_SEPARATOR . $request->file('avatar')->getClientOriginalName(),
            file_get_contents($request->file('avatar')->getRealPath())
        );
        
        $this->model->uploadAvatar($id, $request);
        return redirect('/users');
    }

}
