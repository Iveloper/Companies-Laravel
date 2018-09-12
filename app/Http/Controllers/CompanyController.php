<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use App\Models\CompanyModel;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCompanyPost;

class CompanyController extends Controller {

    public $model;

    public function __construct(CompanyModel $model) {
        $this->model = $model;
    }

    public function index(Request $request) {
        $this->authorize('company');
        $companies = $this->model->getCompanies($request);
        return view('/companies/list')->with('companies', $companies);
    }

    //Returns the view with full information about the company
    public function show($id) {
        $view = $this->model->record($id);
        return view('companies/record', compact('view'));
    }

    //Function that returns the form for adding new Company.
    public function create() {
        $this->authorize('company_create');
        
        $getTypes = $this->model->getContragentTypes();
        return view('companies/add', compact('getTypes'));
    }

    //This function calls the model and updates the information about specific company
    public function update(Request $request, StoreCompanyPost $company) {
       
        $update = $this->model->updateCompany($request->all());
        //check $add 
        return redirect('/company');
    }

    //Function for storing new company in the database
    public function store(Request $request, StoreCompanyPost $company) {
        $add = $this->model->addCompany($request->all());
        return redirect('/company');
    }

    //Function which returns the form for editing a specific company
    public function edit($id) {
        $this->authorize('company_edit');
        $edit = $this->model->record($id);
        $getTypes = $this->model->getContragentTypes();
        return view('/companies/edit', compact('edit', 'getTypes'));
    }

    //This function deletes a certain company
    public function delete($id) {
        $this->authorize('company_delete');
        $delete = $this->model->deleteCompany($id);
        return redirect('/company');
    }

}
