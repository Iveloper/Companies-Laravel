<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCompanyPost;

class CompanyController extends Controller {

    public $model;

    public function __construct(Company $model) {
        $this->model = $model;
    }

    public function index(Request $request) {
        $companies = $this->model->getCompanies($request);
        return view('/companies/list')->with('companies', $companies)
                ->with('model', $this->model);
    }

    //Returns the view with full information about the company
    public function show($id) {
        $company = Company::findOrFail($id);
         $this->authorize('show', $company);
         $view = $this->model->record($id);
        return view('companies/record', compact('view'));
    }

    //Function that returns the form for adding new Company.
    public function create() {
        $this->authorize('create', $this->model);
        $getTypes = $this->model->getContragentTypes();
        return view('companies/add', compact('getTypes'));
    }

    //This function calls the model and updates the information about specific company
    public function update(Request $request, StoreCompanyPost $company) {
        $update = $this->model->updateCompany($request->all());
        Controller::FlashMessages('The company has been updated', 'success');
        return redirect('/company');
    }

    //Function for storing new company in the database
    public function store(Request $request, StoreCompanyPost $company) {
        $add = $this->model->addCompany($request->all());
        Controller::FlashMessages('The company has been added', 'success');
        return redirect('/company');
    }

    //Function which returns the form for editing a specific company
    public function edit($id) {
        $this->authorize('edit', $this->model);
        $edit = $this->model->record($id);
        $getTypes = $this->model->getContragentTypes();
        return view('/companies/edit', compact('edit', 'getTypes'));
    }

    //This function deletes a certain company
    public function delete($id) {
        $this->authorize('delete', $this->model);
        $delete = $this->model->deleteCompany($id);
        Controller::FlashMessages('The company has been deleted!', 'danger');
        return redirect('/company');
    }

}
