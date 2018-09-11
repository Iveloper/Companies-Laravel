<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\URL;
use App\Http\Models\CompanyModel;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCompanyPost;

class CompanyController extends Controller {

    public $model;

    public function __construct(CompanyModel $model) {
        $this->model = $model;
    }

    /**
     * Return companies ...
     * @param Request $request
     * @return type
     */
    public function index(Request $request) {
        $companies = $this->model->getCompanies($request);
        return view('/companies/list')->with('companies', $companies);
    }

    //TO DO: add commments ...
    public function show($id) {
        //TO DO: show contragent type - client, supplier, other ...
        $view = $this->model->record($id);
        return view('companies/record', compact('view'));
    }

    //TO DO: add commments ...
    public function create() {
        $getTypes = $this->model->getContragentTypes();
        return view('companies/add', compact('getTypes'));
    }

    //TO DO: add commments ...
    public function update($id, Request $request, StoreCompanyPost $company) {
        $update = $this->model->updateCompany($request->all());
        //check $add 
        return redirect('/company');
    }

    //TO DO: add commments ...
    public function store(Request $request, StoreCompanyPost $company) {
        $add = $this->model->addCompany($request->all());

        return redirect('/company');
    }

    //TO DO: add commments ...
    public function edit($id) {
        $edit = $this->model->record($id);
        $getTypes = $this->model->getContragentTypes();
        return view('/companies/edit', compact('edit', 'getTypes'));
    }

    //TO DO: add commments ...
    public function delete($id) {
        $delete = $this->model->deleteCompany($id);
        return redirect('/company');
    }

}
