<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class PersonModel extends Model {

    protected $table = 'Person';
    public $timestamps = false;
    public $order = 'ASC';
    public $sort;
    public $page = 1;
    public $perPage = 5;

    //This function returns the list with all records from person database.
    //It also does all the sorting, ordering and searching queries.
    public function getPersons($request) {

        $query = DB::table('Person')
                ->leftJoin('company', 'company.id', '=', 'Person.company_id')
                ->select('Person.*', 'company.name AS company');

        if ($request->get('searchPerson')) {
            foreach ($request->get('searchPerson') as $key => $value) {
                $query->where([
                    ['Person.' . $key, 'LIKE', '%' . $value . '%']
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

        $totalRows = $query->get();
        return [
            'persons' => $query->paginate($this->perPage),
            'sort' => $this->sort,
            'order' => $this->order,
            'perPage' => $this->perPage,
            'total' => $totalRows
        ];
    }

    //Function that adds new person to the database.
    public function addPerson($data) {
        $data = request()->except(['_token']);      
        return DB::table('Person')
                ->insert(['name' => $data['name'],
                    'adress' => $data['adress'],
                    'phone' => $data['phone'],
                    'email' => $data['email'],
                    'company_id' => $data['company'],
                    'user_id' => $data['user_id']
                        ]);
    }

    //Does all the updating for a specific person's information.
    public function updatePerson($data) {     
            return DB::table('Person')
                    ->where('id', $data['id'])
                    ->update(['name' => $data['name'],
                'adress' => $data['adress'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'company_id' => $data['company']
            ]);
    }

    //Selects all the information for a concrete row from Person table.
    public function record($id) {
        return DB::table('Person')
                ->leftJoin('company', 'company.id', '=', 'Person.company_id')
                ->where('Person.id', '=', $id)
                ->select('Person.*', 'company.name AS company')->get();     
    }
    
    //Selects all companies' names and ids.
    public function getAllCompanies(){
        return DB::table('company')
                ->select('company.name', 'company.id')
                ->get();
    }

    //Deletes a person by given ID.
    public function deletePerson($id) {  
        return DB::table('Person')
                ->where('id', '=', $id)
                ->delete();
    }

}
