<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserPost;
use App\Http\Requests\StoreFilePost;


class UserController extends Controller {
    public $model;

    public function __construct(User $model) {
        $this->model = $model;
    }

    //The main function, which does all the magic behind the sorting, searching and ordering the list of users.
    public function index(Request $request) {
        $users = $this->model->getUsers($request);
        return view('/users/list')->with('users', $users)
                ->with('model', $this->model);
    }

    //A function that shows all the information from the database about a concrete user.
    public function show() {
        $view = $this->model->record($id);
        return view('persons/record', compact('view'));
    }

    //Function that returns view with a form for adding new user to the DB.
    public function create() {
        $this->authorize('create', $this->model);
        $lang = $this->model->getLanguage();
        return view('users/add', compact('lang'));
    }

    //Function that updates the information about a user of your choice.
    public function update($id, Request $request) {
        if($request->all()['language_id'] == '2'){
            session()->put('language', 'bg');
        }
        else{
            session()->put('language', 'en');
        }
        $this->model->updateUser($request->all());
        Controller::FlashMessages('The user has been updated', 'success');
        return redirect('/users');
    }

    //A little piece of witchcraft that adds new user to the database.
    public function store(Request $request, StoreUserPost $user) {
        $this->model->addUser($request->all());
        Controller::FlashMessages('The user has been added', 'success');
        return redirect('/users');
    }

    //A function that returns view with a form for editing info of your choice for a concrete user.
    public function edit($id) {
        $this->authorize('edit', $this->model);
        $edit = $this->model->record($id);
        $lang = $this->model->getLanguage();
        $role = $this->model->getRole($id);
        $allPermissions = $this->model->getAllPermissions();
        return view('/users/edit', compact('edit', 'lang', 'role', 'allPermissions'));
    }

    //This function activates an user.
    public function activate($id) {
        $this->authorize('activate', $this->model);
        $this->model->activateUser($id);
        Controller::FlashMessages('The user has been activated', 'success');
        return redirect('/users');
    }

    //This function deactivates an user.
    public function deactivate($id) {
        $this->authorize('deactivate', $this->model);
        $this->model->deactivateUser($id);
        Controller::FlashMessages('The user has been deactivated', 'danger');
        return redirect('/users');
    }

    //This function returns the view for uploading an user's avatar.
    public function upload($id) {
        $this->authorize('upload', $this->model);
        $upload = $this->model->record($id);
        return view('/users/upload', compact('upload'));
    }

    /*This function does all the trickery of storing the uploaded picture in a
     * folder named after the user's username and stores all of his pictures in
     * particular folder.*/
    public function file($id, Request $request, StoreFilePost $file) {
        $this->model->uploadAvatar($id, $request);
        Controller::FlashMessages('The avatar has been uploaded', 'success');
        return redirect('/users');
    }
}
