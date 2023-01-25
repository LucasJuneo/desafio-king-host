<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stories extends Model
{
    use HasFactory;

	protected $fillable = [
        'title',
        'description',
        'thumbnail',
		'hero_id'
    ];

	public function Hero()
    {
        return $this->belongsTo(Heroes::class, 'hero_id');
    }
}
