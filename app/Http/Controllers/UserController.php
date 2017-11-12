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
    	$value = $request->session()->all();
    	if ($request->session()->has('users')) {
    		
    	echo "<script>console.log('" . var_dump($value) . "')</script>";
    	}
    	return view('about');
    }
}
