<?php

namespace App\Http\Controllers;

use App\Models\PersonModel;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Requests\StorePersonPost;
use App\Http\Controllers\Controller;

class PersonController extends Controller {

    public $model;

    public function __construct(PersonModel $model) {
        $this->model = $model;
        $this->companies = new Company();
    }

    //The index function does all the sorting, searching and ordering, as well as visualising all the rows from Person table
    public function index(Request $request) {
        $persons = $this->model->getPersons($request);
        return view('/persons/list')->with('persons', $persons)
                ->with('model', $this->model);
    }

    //Function that shows detailed information about a specific person.
    public function show($id) {
        $person = PersonModel::findOrFail($id);
        $this->authorize('show', $person);
        $view = $this->model->record($id);
        return view('persons/record', compact('view'));
    }

    //A function that shows the form for adding new person to the database.
    public function create() {
        $this->authorize('create', $this->model);
        return view('persons/add');
    }

    //This function updates the information about a specific person and then redirects to the page with all people in the DB.
    public function update($id, Request $request, StorePersonPost $person) {
        $this->model->updatePerson($request->all());
        Controller::FlashMessages('The person has been updated', 'success');
        return redirect('/people');
    }

    //A piece of code which does the magic of storing new person to the database.
    public function store(Request $request, StorePersonPost $person) {
        $add = $this->model->addPerson($request->all());
        Controller::FlashMessages('The person has been inserted', 'success');
        return redirect('/people');
    }

    //Function that visualises the form for editing concrete person
    public function edit($id) {
        $this->authorize('create', $this->model);
        $edit = $this->model->record($id);
        return view('/persons/edit', compact('edit'));
    }

    //Dangerous,but yet very effective piece of code,which deletes a certain person once and for all.
    public function delete($id) {
        $this->authorize('delete', $this->model);
        $delete = $this->model->deletePerson($id);
        Controller::FlashMessages('The person has been deleted', 'danger');
        return redirect('/people');
    }

}
