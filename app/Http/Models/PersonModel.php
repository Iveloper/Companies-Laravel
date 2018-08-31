<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use DB;

class PersonModel extends Model {

    protected $table = 'Person';
    public $timestamps = false;
    public $order = 'ASC';
    public $sort;
    public $page = 1;
    public $perPage = 5;

    public function getPersons($request){
        
         $query = DB::table('Person');
//                 ->join('company', 'company.id', '=', 'Person.company_id')
//                 ->select('Person.*', 'company.name AS company');
     
        if ($request->get('searchPerson')) {
            $query->where([
                ['name', 'LIKE', '%' . $request->get('searchPerson')['name'] . '%'],
                ['adress', 'LIKE', '%' . $request->get('searchPerson')['adress'] . '%'],
                ['phone', 'LIKE', '%' . $request->get('searchPerson')['phone'] . '%'],
                ['email', 'LIKE', '%' . $request->get('searchPerson')['email'] . '%']
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
            'persons' => $query->paginate($this->perPage),
            'sort' => $this->sort,
            'order' => $this->order,
            'perPage' => $this->perPage,
            'total' => $totalRows
        ];
    }
    
    public function addPerson($data) {
        if (isset($data['id']) && $data['id']) {
            $update = DB::table('Person')
                    ->where('id', $data['id'])
                    ->update(['name' => $data['name'],
                'adress' => $data['adress'],
                'phone' => $data['phone'],
                'email' => $data['email']
            ]);
            return $update;
        } else {
            $data = request()->except(['_token']);
            $insert = DB::table('Person')->insert($data);
            return $insert;
        }
    }
    
    public function record($id) {
        $view = DB::table('Person')->where('id', '=', $id)->select('*')->get();
        return $view;
    }
    
    public function deletePerson($id) {
        $delete = DB::table('Person')->where('id', '=', $id)->delete();
        return $delete;
    }
    
}
