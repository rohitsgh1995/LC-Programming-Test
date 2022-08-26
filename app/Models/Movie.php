<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'duration'
    ];

    public function casts()
    {
        return $this->hasMany(Cast::class, 'movie_id', 'id');
    }

    public function dialouges()
    {
        return $this->hasManyThrough(Dialouge::class, Cast::class)->with('cast')->orderBy('start');
    }
}
