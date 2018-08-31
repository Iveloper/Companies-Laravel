<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Http\Request;
class CompanyModel extends Model {

    protected $table = 'company';
    public $timestamps = false;
    public $order = 'ASC';
    public $sort;
    public $page = 1;
    public $perPage = 5;

    public function getCompanies($request) {
         $usercompany = DB::table('Person')
                 ->join('company', 'company.id', '=', 'Person.company_id')
                 ->select('Person.*', 'company.name AS company');
        

        $query = DB::table('company');

        if ($request->get('searchCompany')) {
            $query->where([
                ['name', 'LIKE', '%' . $request->get('searchCompany')['name'] . '%'],
                ['adress', 'LIKE', '%' . $request->get('searchCompany')['adress'] . '%'],
                ['bulstat', 'LIKE', '%' . $request->get('searchCompany')['bulstat'] . '%']
            ]);
        }

        $sortParam = $request->get('sort', 'id');
        //$sort = $query->orderBy($sortParam, $this->order)->get();
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

        $totalRows = $query->get();
        return [
            'companies' => $query->paginate($this->perPage),
            'sort' => $this->sort,
            'order' => $this->order,
            'perPage' => $this->perPage,
            'total' => $totalRows,
            'usercompany' => $usercompany
        ];
    }

    public function deleteCompany($id) {
        $delete = DB::table('company')->where('id', '=', $id)->delete();
        return $delete;
    }

    public function addCompany($data) {
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
            return $update;
        } else {
            $data = request()->except(['_token']);
            $insert = DB::table('company')->insert($data);
            return $insert;
        }
    }

    public function record($id) {
        $view = DB::table('company')->where('id', '=', $id)->select('*')->get();
        return $view;
    }

}
