<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        if (\Auth::check()) {
            return view('home');
        }
        return view('about');
    }

    public function about() 
    {
        return view('about');
    }
}
