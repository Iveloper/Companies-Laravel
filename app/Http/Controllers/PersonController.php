<?php
namespace App\Http\Controllers;

use App\Models\PersonModel;
use Illuminate\Http\Request;
use App\Models\CompanyModel;
use App\Http\Requests\StorePersonPost;

use App\Http\Controllers\Controller;


class PersonController extends Controller{
    public $model;
    
    public function __construct(PersonModel $model) {
        $this->model = $model;
        $this->companies = new CompanyModel();
    }
    
    //The index function does all the sorting, searching and ordering, as well as visualising all the rows from Person table
    public function index(Request $request) {
        $persons = $this->model->getPersons($request);
        return view('/persons/list')->with('persons', $persons);
    }
    
    //Function that shows detailed information about a specific person.
    public function show($id) {
        $view = $this->model->record($id);
        return view('persons/record', compact('view'));
    }
    
    //A function that shows the form for adding new person to the database.
    public function create() {
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
        
        return redirect('/people');
    }
    
    //Function that visualises the form for editing concrete person
    public function edit($id) {
        $edit = $this->model->record($id);
        return view('/persons/edit', compact('edit'));
    }
    
    //Dangerous,but yet very effective piece of code,which deletes a certain person once and for all.
    public function delete($id) {
        $delete = $this->model->deletePerson($id);
        return redirect('/people');
    }
    
}
