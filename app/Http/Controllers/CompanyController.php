<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCompanyPost;

class CompanyController extends Controller {

    public $model;
    public $companiesID;

    public function __construct(Company $model) {
        $this->model = $model;
    }

    //Visualises all the information about a company in 'companies/list' view.
    public function index(Request $request) {
        $companies = $this->model->getCompanies($request);
        $getTypes = $this->model->getContragentTypes();
        return view('/companies/list', compact('getTypes'))->with('companies', $companies)
                        ->with('model', $this->model);
    }

    //Returns the view with full information about the company
    public function show($id) {
        $company = Company::findOrFail($id);
        $this->authorize('show', $company);
        $view = $this->model->record($id);
        $companyID = $id;
        return view('companies/record', compact('view', 'companyID'));
    }

    //Function that returns the form for adding new Company.
    public function create() {
        $this->authorize('create', $this->model);
        $getTypes = $this->model->getContragentTypes();
        $getCountries = $this->model->getAllCountries();
        return view('companies/add', compact('getTypes', 'getCountries'));
    }

    //This function calls the model and updates the information about specific company
    public function update(Request $request, StoreCompanyPost $company) {
        $this->model->updateCompany($request->all());
        Controller::FlashMessages(trans('company.companyUpdate'), 'success');
        return redirect('/company');
    }

    //Function for storing new company in the database
    public function store(Request $request, StoreCompanyPost $company) {
        $this->model->addCompany($request->all());
        Controller::FlashMessages(trans('company.companyAdd'), 'success');
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
        $this->model->deleteCompany($id);
        Controller::FlashMessages(trans('company.companyDelete'), 'danger');
        return redirect('/company');
    }

    //Returns all cities from the database.
    public function city(Request $request) {
        return $this->model->getCities($request->id);
    }
    
    //Deletes multiple companies,based on which checkboxes are checked.
    public function multipleDelete(Request $request) {
        $this->model->deleteMultiple($request->all());
    }

    //Edits contragent types for multiple companies at once.
    public function multipleEdit(Request $request) {
        $this->model->editMultiple($request->all());
    }

}
