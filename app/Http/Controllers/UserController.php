<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	
    public function showProfile(Request $request) {
    	//if (\Auth::check()) {
			//echo "<script>console.log('" . var_dump($value) . "')</script>";
			//return view('profile');
    	//}
    	return view('about');
    }
}
