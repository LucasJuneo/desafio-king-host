<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HeroController extends Controller
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

    public function show(Request $request)
	{
		$hero = $request->name;

		$a = Http::get($this->marvelApiUrl . 'characters', [
			'nameStartsWith' => $hero,
			'ts' => $this->timestamp,
			'apikey' => $this->marvelApiPublicKey,
			'hash' => $this->marvelApiHash
		]);

		return response($a);
	}
}
