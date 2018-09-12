<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use App\Http\Models\LanguageModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LanguageController extends Controller {
    
    public $model;

    public function __construct(LanguageModel $model) {
        $this->model = $model;
    }
    
    //This function changes the locale language based on the user's preferred language.
    public function change($id) {
        $this->model->changeLanguage($id);
        $getKey = $this->model->joinUserLanguage();

            session()->put('language', $getKey);
            return back()->withInput();

    }
}
