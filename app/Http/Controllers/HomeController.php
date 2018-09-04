<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('auth.login');
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
