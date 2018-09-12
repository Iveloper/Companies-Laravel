<?php

namespace App\Http\Models;

use DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class LanguageModel {

    protected $table = 'users';
    public $timestamps = false;
    
    //Changes the preferred language for the person who is logged in the system.
    public function changeLanguage($id) {
        Controller::FlashMessages('The language has been changed', 'success');
        return DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['language_id' => $id]);
    }

    //Joins tables "users" and "languages" and selects the abbreviation of the user's preferred language.
    public static function joinUserLanguage() {
        if (Auth::user()) {
            $query = DB::table('users')
                    ->join('languages', 'users.language_id', '=', 'languages.id')
                    ->select('languages.abbr')
                    ->where('users.id', Auth::user()->id)
                    ->get();
            return $query[0]->abbr;
        }
    }

}
