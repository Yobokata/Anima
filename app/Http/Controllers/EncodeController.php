<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EncodeController extends Controller
{
    public function getEncodingPage() {
        if (\Auth::check()) {
            return view('encode');
        }
        return view('about');
    }
}
