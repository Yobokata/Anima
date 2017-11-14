<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;

class AnimeController extends Controller
{
	public function getEpisodeList($anime_id) {
		$episodeList = DB::table('episodes')->join('anime', 'episodes.anime_id', '=', 'anime.id')->select('anime.name')->addSelect('episodes.number')->where('anime.id', '=', $anime_id)->orderBy('episodes.number')->get();
		$anime = DB::table('anime')->where('id', '=', $anime_id)->first();
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
		//if (DB::table('anime').select('name')->) //check if the anime already exists
		DB::table('anime')->insert(['name' => $anime]);
		$animeId = DB::getPdo()->lastInsertId();

		//Create cover if it doesn't exist already
		if(!file_exists('images/covers/' . $animeId . '.png')) {	
			file_put_contents('images/covers/' . $animeId . '.png', fopen($this->get_anime_cover_url($anime), 'r'));
		}
		if (!file_exists('videos/' . $animeId)) {
			mkdir('videos/' . $animeId);
		}
		if (file_exists('videos/' . $animeId)) {
			set_time_limit(3600 * 3);

			//Get files in folder with anime name
			$list = glob("F:/downloads/Seasonal/*" . $anime . "*.mkv");
			foreach($list as $episode) {
				//Get episode number from file
				$fileName = basename($episode);
				preg_match('/- \d{1,5}/', $fileName, $matches);
				$episodeNumber = substr($matches[0], 2);

				//Insert episode into table
				DB::table('episodes')->insert(['anime_id' => $animeId, 'number' => $episodeNumber, 'extension' => 'mkv']);
				$episodeId = DB::getPdo()->lastInsertId();
				//this reencodes all the episodes always so find another solution (probably with file upload?)
				//Encode episode
				//shell_exec('handbrake.exe -i "' . $episode . '" --audio-lang-list "jpn" --first-audio --aencoder "copy" --subtitle-lang-list "eng" --first-subtitle --subtitle-burned -o "D:/xampp/htdocs/Server/Anisite/public/videos/' . $animeId . '/' . $episodeId . '.mkv"');
			}
			//shell_exec('handbrake.exe -i "F:/downloads/[CBM] Gurren Lagann 1-27 Complete (Dual Audio) [BDRip-720p-8bit]/[CBM]_Gurren_Lagann_-_01_-_Bust_Through_the_Heavens_With_Your_Drill!_[720p]_[D2E69407].mkv" --audio-lang-list "jpn" --first-audio --aencoder "copy" --subtitle-lang-list "eng" --first-subtitle --subtitle-burned -o "D:/xampp/htdocs/Server/Anisite/public/videos/Encoded/Tengen Toppa Gurren Lagann/Tengen Toppa Gurren Lagann 1.mkv"');
		}
		return view('about');
	}
}
