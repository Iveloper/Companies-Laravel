<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    //Static function creating flash messages dynamically.
    public static function FlashMessages($message, $alert = 'success') {
        Session::flash('message', $message);
        Session::flash('alert-class', 'alert-'.$alert);
    }

}
