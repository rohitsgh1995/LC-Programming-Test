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
    public $dialougeList = [];

    public function mount()
    {
        $this->casts = [
            ['name' => '', 'gender' => '', 'character' => '']
        ];

        $this->dialougeList = [
            ['dialouge' => '', 'character' => '', 'start' => '00:00:00.000', 'end' => '00:00:00.000']
        ];
    }

    public function render()
    {
        return view('livewire.movies.create');
    }

    public function updatedDialougeList()
    {
        foreach($this->dialougeList as $key => $value)
        {
            $this->dialougeList[$key]['start'] = date("H:i:s.v", strtotime($value['start']));
            $this->dialougeList[$key]['end'] = date("H:i:s.v", strtotime($value['end']));
        }
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

    public function addDialougeFields()
    {
        $this->dialougeList[] = ['dialouge' => '', 'character' => '', 'start' => '00:00:00.000', 'end' => '00:00:00.000'];
    }

    public function removeDialougeFields($key)
    {
        unset($this->dialougeList[$key]);
        $this->dialougeList = array_values($this->dialougeList);
    }

    public function createMovie()
    {
        $this->validate([
            'movie_name' => 'required',
            'movie_duration' => 'required',
            'casts.*.name' => 'required',
            'casts.*.gender' => 'required',
            'casts.*.character' => 'required|distinct:strict,ignore_case',
            'dialougeList.*.dialouge' => 'required',
            'dialougeList.*.character' => 'required',
            'dialougeList.*.start' => 'required|date_format:H:i:s.v|before:dialougeList.*.end',
            'dialougeList.*.end' => 'required|date_format:H:i:s.v|after:dialougeList.*.start'
        ],
        [
            'movie_name.required' => 'Movie name is required.',
            'movie_duration.required' => 'Movie duration is required.',
            'casts.*.name.required' => 'Cast name is required.',
            'casts.*.gender.required' => 'Cast gender is required.',
            'casts.*.character.required' => 'Cast character is required.',
            'casts.*.character.distinct' => 'Cast character field has a duplicate value.',
            'dialougeList.*.dialouge.required' => 'Dialouge is required.',
            'dialougeList.*.character.required' => 'Character is required.',
            'dialougeList.*.start.required' => 'Start time is required.',
            'dialougeList.*.start.before' => 'Start time must be  a time before end time.',
            'dialougeList.*.end.required' => 'End time is required.',
            'dialougeList.*.end.after' => 'End time must be a time after start time.'
        ]);

        $create = Movie::create([
            'name' => $this->movie_name,
            'duration' => $this->movie_duration
        ]);

        foreach($this->casts as $c)
        {
            $set = Cast::create([
                'movie_id' => $create->id,
                'character_name' => $c['character'],
                'name' => $c['name'],
                'gender' => $c['gender']
            ]);

            foreach($this->dialougeList as $dl)
            {
                if($dl['character'] === $c['character'])
                {
                    Dialouge::create([
                        'movie_id' => $create->id,
                        'cast_id' => $set->id,
                        'dialouge' => $dl['dialouge'],
                        'start' => $dl['start'],
                        'end' => $dl['end']
                    ]);
                }
            }
        }
        
        return redirect()->route('movies')->with('success', 'New movie created successfully.');
    }    
}
