<?php

namespace App\Http\Livewire\Movies;

use Livewire\Component;
use App\Models\Movie;
use App\Models\Cast;
use App\Models\Dialouge;

class Create extends Component
{
    public $movie_name, $movie_duration;

    public $casts = [];

    public function mount()
    {
        $this->casts = [
            ['name' => '', 'gender' => '', 'character' => '']
        ];
    }

    public function render()
    {
        return view('livewire.movies.create');
    }

    public function createMovie()
    {
        $this->validate([
            'movie_name' => 'required',
            'movie_duration' => 'required',
            'casts.*.name' => 'required',
            'casts.*.gender' => 'required',
            'casts.*.character' => 'required',
        ],
        [
            'movie_name.required' => 'Movie name is required.',
            'movie_duration.required' => 'Movie duration is required.',
            'casts.*.name.required' => 'Cast name is required.',
            'casts.*.gender.required' => 'Cast gender is required.',
            'casts.*.character.required' => 'Cast character is required.',
        ]);

        $create = Movie::create([
            'name' => $this->movie_name,
            'duration' => $this->movie_duration
        ]);

        foreach($this->casts as $c)
        {
            Cast::create([
                'movie_id' => $create->id,
                'character_name' => $c['character'],
                'name' => $c['name'],
                'gender' => $c['gender']
            ]);
        }
        
        return redirect()->route('movies')->with('success', 'New movie created successfully.');
    }

    public function addCastField()
    {
        $this->casts[] = ['name' => '', 'gender' => '', 'character' => ''];
    }

    public function removeCastField($key)
    {
        unset($this->casts[$key]);
        $this->casts = array_values($this->casts);
    }
}
