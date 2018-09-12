<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\UserModel;
use App\Http\Requests\StoreUserPost;
use App\Http\Requests\StoreFilePost;


class UserController extends Controller {

    public $model;

    public function __construct(UserModel $model) {
        $this->model = $model;
    }

    //The main function, which does all the magic behind the sorting, searching and ordering the list of users.
    public function index(Request $request) {
        $users = $this->model->getUsers($request);
        return view('/users/list')->with('users', $users);
    }

    //A function that shows all the information from the database about a concrete user.
    public function show() {
        $view = $this->model->record($id);
        return view('persons/record', compact('view'));
    }

    //Function that returns view with a form for adding new user to the DB.
    public function create() {
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
        return redirect('/users');
    }

    //A little piece of witchcraft that adds new user to the database.
    public function store(Request $request, StoreUserPost $user) {
        $add = $this->model->addUser($request->all());
        return redirect('/users');
    }

    //A function that returns view with a form for editing info of your choice for a concrete user.
    public function edit($id) {
        $edit = $this->model->record($id);
        $lang = $this->model->getLanguage();
        return view('/users/edit', compact('edit', 'lang'));
    }

    //This function activates an user.
    public function activate($id) {
        $activate = $this->model->activateUser($id);
        return redirect('/users');
    }

    //This function deactivates an user.
    public function deactivate($id) {
        $delete = $this->model->deactivateUser($id);

        return redirect('/users');
    }

    //This function returns the view for uploading an user's avatar.
    public function upload($id) {
        $upload = $this->model->record($id);

        return view('/users/upload', compact('upload'));
    }

    /*This function does all the trickery of storing the uploaded picture in a
     * folder named after the user's username and stores all of his pictures in
     * particular folder.*/
    public function file($id, Request $request, StoreFilePost $file) {
        $this->model->uploadAvatar($id, $request);
        return redirect('/users');
    }

}
