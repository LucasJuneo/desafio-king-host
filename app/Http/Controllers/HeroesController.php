<?php

namespace App\Http\Controllers;

use App\Models\Heroes;
use App\Models\Stories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class HeroesController extends Controller
{
	private $marvelApiUrl;
	private $marvelApiPublicKey;
	private $marvelApiPrivateKey;
	private $timestamp;
	private $marvelApiHash;

	public function __construct()
	{
		$this->marvelApiUrl = config('marvel.url');
		$this->marvelApiPublicKey = config('marvel.public_key');
		$this->marvelApiPrivateKey = config('marvel.private_key');
		$this->timestamp = Carbon::now()->timestamp;
		$this->marvelApiHash = md5(
			$this->timestamp
			.$this->marvelApiPrivateKey
			.$this->marvelApiPublicKey
		);
	}

    public function fetchHeroes(Request $request)
	{
		$heroName = $request->name;

		$response = Http::get($this->marvelApiUrl . 'characters', [
			'nameStartsWith' => $heroName,
			'ts' => $this->timestamp,
			'apikey' => $this->marvelApiPublicKey,
			'hash' => $this->marvelApiHash
		]);

		if ($response['code'] != 200) {
			return response()->json(['success' => false]);
		}

		return response()->json([
			'success' => true,
			'heroes' => $response['data']
		]);
	}

	public function index()
	{
		$heroes = Heroes::all();

		return response()->json([
			'success' => true,
			'heroes' => $heroes
		]);
	}

	public function store(Request $request)
	{
		$this->resetDataBase();

		foreach ($request->heroes as $hero) {
			Heroes::create([
				'name' => $hero['name'],
				'img' => $hero['img'],
				'description' => $hero['description'],
				'api_id' => $hero['id'],
			]);
		}

		return response()->json(['success' => true]);
	}

	private function resetDataBase()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		Heroes::truncate();
		Stories::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
