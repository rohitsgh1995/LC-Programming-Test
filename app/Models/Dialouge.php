<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dialouge extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id', 'cast_id', 'dialouge', 'start', 'end'
    ];

    public function cast()
    {
        return $this->belongsTo(Cast::class, 'cast_id', 'id');
    }
}
