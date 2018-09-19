<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {


    public function __construct() {
        
    }


    public function index() {
        return view('auth.login');
    }

    public function register(){
        return view('auth.register');
    }
    public function auth(Request $request) {
        if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password'), 'active' => 1])) {
            // The user is active, not suspended, and exists.
            return redirect()->route('company_index');
        }

        return redirect()->back();
    }

    public function logout() {
        \Auth::logout();
        return redirect()->route('login');
    }

}
