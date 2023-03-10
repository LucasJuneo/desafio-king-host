<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Heroes extends Model
{
    use HasFactory;

	protected $fillable = [
        'name',
        'img',
        'description',
		'api_id',
    ];

	public function stories()
	{
		return $this->hasMany(Stories::class, 'hero_id');
	}
}
