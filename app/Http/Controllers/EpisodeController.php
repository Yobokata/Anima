<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class EpisodeController extends Controller
{
    public function getEpisode($anime, $episode) {
    	$video = DB::table('episodes')->join('anime', 'episodes.anime_id', '=', 'anime.id')->where('anime.name', '=', $anime)->where('episodes.number', '=', $episode)->first();
		return view('watch')->with('video', $video);
    }
}
