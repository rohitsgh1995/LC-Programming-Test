<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id', 'character_name', 'name', 'gender'
    ];

    public function dialouges()
    {
        return $this->hasMany(Dialouge::class, 'cast_id', 'id');
    }
}
