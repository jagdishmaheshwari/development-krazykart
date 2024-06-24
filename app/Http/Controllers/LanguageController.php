<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLang($locale)
    {
        // Check if the locale is supported
        // pr(App::getLocale());
        $supportedLocales = ['en', 'guj']; // Add more supported languages here
        if (in_array($locale, $supportedLocales)) {
            Session::put('applocale', $locale);
            App::setLocale($locale);
        }else{
        }
        // prd(App::getLocale());

        return redirect()->back();
    }
}
