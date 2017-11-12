<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ListController extends Controller
{

	public function getAnimeList() {
		$animeList = DB::table('anime')->distinct()->orderBy('name')->paginate(20);
		return view('list')->with('list', $animeList);
	}
}