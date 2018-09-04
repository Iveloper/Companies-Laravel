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
    
    public function index(Request $request) {
        $persons = $this->model->getPersons($request);
        return view('/persons/list')->with('persons', $persons);
    }
    
    public function show($id) {
        $view = $this->model->record($id);
        return view('persons/record', compact('view'));
    }
    
    public function create() {
        return view('persons/add');
    }
    
    public function update($id, Request $request, StorePersonPost $person) {
        $this->model->updatePerson($request->all());
        return redirect('/people');
    }
    
     public function store(Request $request, StorePersonPost $person) {
        $add = $this->model->addPerson($request->all());
        
        return redirect('/people');
    }
    
    public function edit($id) {
        $edit = $this->model->record($id);
        return view('/persons/edit', compact('edit'));
    }
    
    public function delete($id) {
        $delete = $this->model->deletePerson($id);
        return redirect('/people');
    }
    
}
