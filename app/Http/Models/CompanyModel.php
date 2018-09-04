<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use App\Http\Controllers\Controller;

class CompanyModel extends Model {

    protected $table = 'company';
    public $timestamps = false;
    public $order = 'ASC';
    public $sort;
    public $page = 1;
    public $perPage = 5;

    public function getCompanies($request) {


        $query = DB::table('company')
                ->leftJoin('company_type', 'company.contragent_type', '=', 'company_type.id')
                ->select('company.id','company.name','adress','bulstat','phone', 'email', 'note', 'company_type.name as contragent_type');
        if ($request->get('searchCompany')) {
            $query->where([
                ['name', 'LIKE', '%' . $request->get('searchCompany')['name'] . '%'],
                ['adress', 'LIKE', '%' . $request->get('searchCompany')['adress'] . '%'],
                ['bulstat', 'LIKE', '%' . $request->get('searchCompany')['bulstat'] . '%']
            ]);
        }

        $sortParam = $request->get('sort', 'id');
        if ($request->get('sort')) {
            if ($request->get('order') && $request->get('order') == 'ASC') {
                $this->order = 'DESC';
                $this->sort = $query->orderBy($sortParam, $this->order)->get();
            } else {
                $this->order = 'ASC';
                $this->sort = $query->orderBy($sortParam, $this->order)->get();
            }
        }

        if ($request->get('option')) {
            $this->perPage = $request->get('option');
        }

        $query->where('user_id', '=', \Auth::user()->id);
        
        $rows = $query->paginate($this->perPage);

        return [
            'companies' => $rows,
            'sort' => $this->sort,
            'order' => $this->order,
            'perPage' => $this->perPage
        ];
    }

    public function deleteCompany($id) {
        $delete = DB::table('company')->where('id', '=', $id)->delete();
        Controller::FlashMessages('The company has been', 'danger');
        return $delete;
    }

    public function addCompany($data) {
          $data = request()->except(['_token']);
            $insert = DB::table('company')->insert($data);
            Controller::FlashMessages('The company has been added', 'success');
            return $insert;
        }

    public function updateCompany($data) {
        if (isset($data['id']) && $data['id']) {
            $update = DB::table('company')
                    ->where('id', $data['id'])
                    ->update(['name' => $data['name'],
                'adress' => $data['email'],
                'bulstat' => $data['bulstat'],
                'contragent_type' => $data['contragent_type'],
                'email' => $data['email'],
                'phone' => $data['phone']
            ]);
            Controller::FlashMessages('The company has been updated', 'success');
            return $update;
        }
    }

    public function record($id) {
        $view = DB::table('company')->where('id', '=', $id)->select('*')->get();
        return $view;
    }
    
    public function getContragentTypes() {
        $query = DB::table('company_type')->select('*')->get();
        return $query;
    }

}
