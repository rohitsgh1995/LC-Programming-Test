<?php

namespace App\Http\Livewire\Movies;

use Livewire\Component;
use App\Models\Movie;

class Index extends Component
{
    public function render()
    {
        return view('livewire.movies.index', [
            'movies' => Movie::with(['casts', 'dialouges'])->orderBy('id', 'desc')->get(),
        ]);
    }

    public function setTime($time, $format = '%02d:%02d')
    {
        if ($time < 1) {
            return;
        }
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return sprintf($format, $hours, $minutes);
    }
}
