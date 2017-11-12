<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EpisodeController extends Controller
{
    public function getEpisode($anime_id, $episode) {
    	$video = DB::table('episodes')->join('anime', 'episodes.anime_id', '=', 'anime.id')->where('anime.id', '=', $anime_id)->where('episodes.number', '=', $episode)->first();
		return view('watch')->with('video', $video);
    }
}
