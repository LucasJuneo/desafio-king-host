<?php

namespace App\Http\Controllers;

use App\Models\Heroes;
use App\Models\Stories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StoriesController extends Controller
{
    public function index(Request $request)
	{
		$hero = Heroes::find($request->id)->first();

		if (count($hero->stories) > 0) {
			return response()->json([
				'success' => true,
				'stories' => $hero->stories
			]);
		}
		
		// se o herói não tem historias no banco, busca na API
		$fetchedStories = $this->fetchStories($hero->api_id);

		if ($fetchedStories == false) {
			return response()->json(['success' => false]);
		}

		$stories = [];
		foreach ($fetchedStories['results'] as $fetchedStory) {
			$thumbnail = $fetchedStory['thumbnail']['path'].$fetchedStory['thumbnail']['extension'];

			$story = [
				'title' => $fetchedStory['title'],
				'description' => $fetchedStory['description'],
				'thumbnail' => $thumbnail,
				'hero_id' => $hero->id,
			];

			Stories::create($story);
			array_push($stories, $story);
		}

		return response()->json([
			'success' => true,
			'stories' => $stories
		]);
	}

	private function fetchStories($characterId)
	{
		$marvelApiUrl = config('marvel.url');
		$marvelApiPublicKey = config('marvel.public_key');
		$marvelApiPrivateKey = config('marvel.private_key');
		$timestamp = Carbon::now()->timestamp;
		$marvelApiHash = md5($timestamp.$marvelApiPrivateKey.$marvelApiPublicKey);

		$response = Http::get($marvelApiUrl . 'characters/' . $characterId . '/comics', [
			'characterId' => $characterId,
			'ts' => $timestamp,
			'apikey' => $marvelApiPublicKey,
			'hash' => $marvelApiHash,
			'limit' => 5
		]);

		if ($response['code'] != 200) {
			return false;
		}

		return $response['data'];
	}
}
