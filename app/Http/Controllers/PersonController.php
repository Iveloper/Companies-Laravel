<?php

namespace App\Http\Controllers;

use App\Http\Models\PersonModel;
use Illuminate\Http\Request;
use App\Http\Models\CompanyModel;
/**
 * Description of PersonController
 *
 * @author ivelin
 */
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
    
    public function personadd(Request $request) {
        
        $companies = $this->companies->getCompanies($request);

        return view('persons/add', $companies);
    
        
    }
    
    public function add(Request $request){

        $this->validate($request, [
            'name' => 'min:5|max:30|required',
            'adress' => 'min:10|required',
            'phone' => 'size: 10',
            'email' => 'min:8|max:100'
        ]);
        $add = $this->model->addPerson($_POST);
        return redirect('/people');
        
    }
    
    public function record($id) {
        $view = $this->model->record($id);
        return view('persons/record', compact('view'));
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
