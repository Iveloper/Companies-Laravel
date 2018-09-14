<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Company extends Model {

    protected $table = 'company';
    public $timestamps = false;
    public $order = 'ASC';
    public $sort;
    public $page = 1;
    public $perPage = 5;

    //Shows a list of all records from Company table. Stays behind all the sorting, searching, ordering and paginating.
    public function getCompanies($request) {
        $query = DB::table('company')
                ->leftJoin('company_type', 'company.contragent_type', '=', 'company_type.id')
                ->select('company.id', 'company.name', 'adress', 'bulstat', 'phone', 'email', 'note', 'company_type.name as contragent_type');

        if ($request->get('searchCompany')) {
            foreach ($request->get('searchCompany') as $key => $value) {
                $query->where([
                    ['company.' . $key, 'LIKE', '%' . $value . '%']
                ]);
            }
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

    //Adds new company to the Company table.
    public function addCompany($data) {
        $data = request()->except(['_token']);
        return DB::table('company')
                        ->insert($data);
    }

    //Updates the information for a concrete company.
    public function updateCompany($data) {
        return DB::table('company')
                        ->where('id', $data['id'])
                        ->update(['name' => $data['name'],
                            'adress' => $data['adress'],
                            'bulstat' => $data['bulstat'],
                            'contragent_type' => $data['contragent_type'],
                            'email' => $data['email'],
                            'phone' => $data['phone']
        ]);
    }

    //Shows all the information for a company by given ID.    
    public function record($id) {
        return DB::table('company')
                        ->leftJoin('company_type', 'company_type.id', '=', 'company.contragent_type')
                        ->select('company.*', 'company_type.name AS contragent')
                        ->where('company.id', '=', $id)
                        ->get();
    }

    //Shows the available contragent types from the "company_type" table.
    public function getContragentTypes() {
        return DB::table('company_type')
                        ->select('*')
                        ->get();
    }
    
    //Deletes a company by given ID.
    public function deleteCompany($id) {
        return DB::table('company')
                        ->where('id', '=', $id)
                        ->delete();
    }
}
