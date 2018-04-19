<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Anime;
use App\Episode;

class TranscodeController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
    }
    
    public function getTranscodingPage() {
        if (\Auth::user()->is_admin) {
            return view('transcode');
        }
        return view('about');
    }

	public function transcode(Request $request, $anime_name) {
		if (!\Auth::user()->is_admin) {
			return view('about');
		}
		$anime = $this->getAnime($anime_name);
		$this->createCover($anime);
		if (!file_exists('videos/' . $anime->id)) {
			mkdir('videos/' . $anime->id);
		}
		set_time_limit(3600 * 3);
		$filePaths = glob("F:/downloads/Seasonal/*" . $anime->name . "*.mkv");
		if (empty($filePaths)) {
			$filePaths = glob("F:/downloads/Seasonal/*" . $anime->alt_name . "*.mkv");				
		}
		foreach ($filePaths as $filePath) {
			$episodeId = $this->getEpisodeData($filePath, $anime->id);
			//Transcode current file
			shell_exec('handbrake.exe -i "' . $filePath . '" --audio-lang-list "jpn" --first-audio --aencoder "copy" --subtitle-lang-list "eng" --first-subtitle --subtitle-burned -o "D:/xampp/htdocs/Server/public/videos/' . $anime->id . '/' . $episodeId . '.mkv"');
		}
		return view('transcode');
	}

	private function getAnime($anime_name) {
		$anime = Anime::where('name', '=', $anime_name)->first();
		if ($anime == null) {
			$anime = new Anime;
			$anime->name = $anime_name;
			$anime->save();
		}
		return $anime;
	}

	private function createCover($anime) {
		//Create cover if it doesn't exist already
		if(file_exists('images/covers/' . $anime->id . '.png')) {
			return;
		}
		$cover_url = $this->getAnimeCoverUrl($anime->name);
		if ($cover_url == "" && $anime->alt_name != "") {
			$cover_url = $this->getAnimeCoverUrl($anime->alt_name);
		}
		if ($cover_url != "") {
			file_put_contents('images/covers/' . $anime->id . '.png', $cover_url, 'r');
		}
	}
    
    private function getAnimeCoverUrl($anime) {
		$html = file_get_contents('https://myanimelist.net/anime.php?q=' . $anime);
		$imgNameIndex = strpos($html, 'alt="' . $anime . '"');
		if ($imgNameIndex === -1) {
			//die('image not found');
			return "";
		}
		$html = substr($html, $imgNameIndex);

		$dataSrc = strpos($html, 'data-src="');
		if ($dataSrc === -1) {
			//die('data-src not found');
			return "";
		}
		$dataSrc += strlen('data-src="');
		$srcEnd = strpos($html, '?');
		if ($srcEnd === -1) {
			//die('data-src unexpected format');
			return "";
		}
		$srcEnd -= $dataSrc;
		$url = substr($html, $dataSrc, $srcEnd);
		$parts = explode('/', $url);
		if (count($parts) < 5) {
			//die('unexpected url: ' . $url);
			return "";
		}
		unset($parts[3]);
		unset($parts[4]);
		return implode('/', $parts);
    }

	private function getEpisodeData($filePath, $animeId) {
		//Get episode number from file path
		$fileName = basename($filePath);
		preg_match('/- \d{1,5}/', $fileName, $matches);
		$episodeNumber = substr(end($matches), 2);

		$episode = Episode::where('anime_id', '=', $animeId)->where('number', '=', $episodeNumber)->first();
		if ($episode == null) {
			//Insert episode into table
			$episode = new Episode;
			$episode->anime_id = $animeId;
			$episode->number = $episodeNumber;
			$episode->extension = 'mkv';
			$episode->save();
		}
		return $episode->id;
	}
}
