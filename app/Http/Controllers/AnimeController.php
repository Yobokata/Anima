<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class AnimeController extends Controller
{
	public function getEpisodeList($anime) {
		$episodeList = DB::table('episodes')->join('anime', 'episodes.anime_id', '=', 'anime.id')->select('anime.name')->addSelect('episodes.number')->where('anime.name', '=', $anime)->orderBy('episodes.number')->get();
		$anime = DB::table('anime')->where('name', '=', $anime)->first();
		if ($anime != null) {
		$anime->image = '../../' . $anime->image;
		}
		return view('anime')->with(['episodeList' => $episodeList, 'anime' => $anime]);
	}

	private function get_anime_cover_url($anime) {
		$html = file_get_contents('https://myanimelist.net/anime.php?q=' . $anime);
		$imgNameIndex = strpos($html, 'alt="' . $anime . '"');
		if ($imgNameIndex === -1) {
			die('image not found');
		}
		$html = substr($html, $imgNameIndex);

		$dataSrc = strpos($html, 'data-src="');
		if ($dataSrc === -1) {
			die('data-src not found');
		}
		$dataSrc += strlen('data-src="');
		$srcEnd = strpos($html, '?');
		if ($srcEnd === -1) {
			die('data-src unexpected format');
		}
		$srcEnd -= $dataSrc;
		$url = substr($html, $dataSrc, $srcEnd);
		$parts = explode('/', $url);
		if (count($parts) < 5) {
			die('unexpected url: ' . $url);
			}
		unset($parts[3]);
		unset($parts[4]);
		return implode('/', $parts);
	}

	public function insertAnime(Request $request, $anime) {
		DB::table('anime')->insert(['name' => $anime, 'image' => 'images/covers/' . $anime . '.png']);
		file_put_contents('images/covers/' . $anime . '.png', fopen($this->get_anime_cover_url($anime), 'r'));
		return view('about');
	}
}
