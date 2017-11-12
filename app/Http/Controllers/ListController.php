<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ListController extends Controller
{

	public function getAnimeList() {
		$animeList = DB::table('anime')	->select('name')->addSelect('image')->distinct()->orderBy('name')->get();
		return view('list')->with('list', $animeList);
	}
}