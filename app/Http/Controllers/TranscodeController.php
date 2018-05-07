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
		$file_paths = glob("F:/downloads/Seasonal/*" . $anime->name . "*.mkv");
		if (empty($file_paths)) {
			$file_paths = glob("F:/downloads/Seasonal/*" . $anime->alt_name . "*.mkv");				
		}
		foreach ($file_paths as $filePath) {
			$episode_id = $this->getEpisodeData($filePath, $anime->id);
			//Transcode current file
			shell_exec('handbrake.exe -i "' . $filePath . '" --audio-lang-list "jpn" --first-audio --aencoder "copy" --subtitle-lang-list "eng" --first-subtitle --subtitle-burned -o "D:/xampp/htdocs/Server/public/videos/' . $anime->id . '/' . $episode_id . '.mkv"');
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
		$img_name_index = strpos($html, 'alt="' . $anime . '"');
		if ($img_name_index === -1) {
			//die('image not found');
			return "";
		}
		$html = substr($html, $img_name_index);

		$data_src = strpos($html, 'data-src="');
		if ($data_src === -1) {
			//die('data-src not found');
			return "";
		}
		$data_src += strlen('data-src="');
		$src_end = strpos($html, '?');
		if ($src_end === -1) {
			//die('data-src unexpected format');
			return "";
		}
		$src_end -= $data_src;
		$url = substr($html, $data_src, $src_end);
		$parts = explode('/', $url);
		if (count($parts) < 5) {
			//die('unexpected url: ' . $url);
			return "";
		}
		unset($parts[3]);
		unset($parts[4]);
		return implode('/', $parts);
    }

	private function getEpisodeData($file_path, $anime_id) {
		//Get episode number from file path
		$fileName = basename($file_path);
		preg_match('/- \d{1,5}/', $fileName, $matches);
		$episode_number = substr(end($matches), 2);

		$episode = Episode::where('anime_id', '=', $anime_id)->where('number', '=', $episode_number)->first();
		if ($episode == null) {
			//Insert episode into table
			$episode = new Episode;
			$episode->anime_id = $anime_id;
			$episode->number = $episode_number;
			$episode->extension = 'mkv';
			$episode->save();
		}
		return $episode->id;
	}
}
