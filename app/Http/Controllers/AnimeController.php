<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anime;
use App\Episode;

class AnimeController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}
	
	public function getAnimeList() {
		$animeList = Anime::orderBy('name')->get();
		return view('list')->with('list', $animeList);
	}
	
	public function getEpisodeList($anime_id) {
		$anime = Anime::where('id', '=', $anime_id)->first();
		$episodeList = Episode::where('episodes.anime_id', '=', $anime_id)->orderBy('episodes.number')->get();
		return view('anime')->with(['episodeList' => $episodeList, 'anime' => $anime]);
	}
    
	public function getEpisode($anime_id, $episode) {
		$anime = Anime::where('id', '=', $anime_id)->first();
		$episodes = Episode::where('anime_id', '=', $anime_id)->get();
		$video = $episodes->where('number', '=', $episode)->first();
		return view('watch')->with(['anime' => $anime->name, 'video' => $video, 'lastEpisode' => $episodes->max('number')]);
    }
}