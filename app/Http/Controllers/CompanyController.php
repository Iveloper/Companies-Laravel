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

class CompanyController extends Controller {

    public $model;

    public function __construct(CompanyModel $model) {
        $this->model = $model;
    }

    public function index(Request $request) {
        $companies = $this->model->getCompanies($request);
        return view('/companies/list')->with('companies', $companies);
    }

    public function companydelete($id) {
        $delete = $this->model->deleteCompany($id);
        return redirect('/company');
    }

    public function companyadd(Request $request) {
        $this->validate($request, [
            'name' => 'min:5|max:30|required',
            'adress' => 'min:10|required',
            'bulstat' => 'max:10|required',
            'email' => 'min:8|max:100',
            'phone' => 'size:10|required',
            'note' => 'max: 250'
        ]);
        $add = $this->model->addCompany($_POST);
        return redirect('/company');
    }

    public function companyrecord($id) {
        $view = $this->model->record($id);
        return view('companies/record', compact('view'));
    }

    public function companyedit($id) {
        $edit = $this->model->record($id);
        return view('/companies/edit', compact('edit'));
    }

}
