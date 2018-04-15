<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EpisodeController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
    }
    
    public function getEpisode($anime_id, $episode) {
    	$video = DB::table('episodes')->where('anime_id', '=', $anime_id)->where('number', '=', $episode)->first();
		return view('watch')->with('video', $video);
    }
}
