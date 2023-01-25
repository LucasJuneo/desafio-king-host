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
    public function fetchHeroes(Request $request)
	{
		$heroName = $request->name;
		$marvelApiUrl = config('marvel.url');
		$marvelApiPublicKey = config('marvel.public_key');
		$marvelApiPrivateKey = config('marvel.private_key');
		$timestamp = Carbon::now()->timestamp;
		$marvelApiHash = md5($timestamp.$marvelApiPrivateKey.$marvelApiPublicKey);

		$response = Http::get($marvelApiUrl . 'characters', [
			'nameStartsWith' => $heroName,
			'ts' => $timestamp,
			'apikey' => $marvelApiPublicKey,
			'hash' => $marvelApiHash
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

	public function resetDataBase()
	{
		DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		Heroes::truncate();
		Stories::truncate();
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	}
}
