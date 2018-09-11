<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller {

    public function change($id) {
        session()->put('language', $this->toggle($id));
        return back()->withInput();
    }

    public function toggle($id) {
        if ($id == '2') {
            return 'bg';
        }
        return 'en';
    }

}
