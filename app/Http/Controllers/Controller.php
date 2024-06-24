<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;


abstract class Controller
{
    function __construct()
    {
        if (Session::has('applocale')) {
            App::setLocale(Session::get('applocale'));
        }
    }
}
