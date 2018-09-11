<?php
namespace App\Http\Controllers;

use App\Http\Models\PersonModel;
use Illuminate\Http\Request;
use App\Http\Models\CompanyModel;
use App\Http\Requests\StorePersonPost;


class PersonController extends Controller{
    public $model;
    
    public function __construct(PersonModel $model) {
        $this->model = $model;
        $this->companies = new CompanyModel();
    }
    
    //TO DO: add commments ...
    public function index(Request $request) {
        $persons = $this->model->getPersons($request);
        return view('/persons/list')->with('persons', $persons);
    }
    
    //TO DO: add commments ...
    public function show($id) {
        $view = $this->model->record($id);
        return view('persons/record', compact('view'));
    }
    
    //TO DO: add commments ...
    public function create() {
        return view('persons/add');
    }
    
    //TO DO: add commments ...
    public function update($id, Request $request, StorePersonPost $person) {
        $this->model->updatePerson($request->all());
        return redirect('/people');
    }
    
    //TO DO: add commments ...
     public function store(Request $request, StorePersonPost $person) {
        $add = $this->model->addPerson($request->all());
        
        return redirect('/people');
    }
    
    //TO DO: add commments ...
    public function edit($id) {
        $edit = $this->model->record($id);
        return view('/persons/edit', compact('edit'));
    }
    
    //TO DO: add commments ...
    public function delete($id) {
        $delete = $this->model->deletePerson($id);
        return redirect('/people');
    }
    
}
