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
            [
                'name' => '',
                'gender' => '',
                'character' => '',
                'dialougeList' => [
                    [
                        'dialouge' => '',
                        'start' => '00:00:00.000',
                        'end' => '00:00:00.000'
                    ]
                ]
            ]
        ];
    }

    public function render()
    {
        return view('livewire.movies.create');
    }

    public function formatStartTime($c_key, $d_key)
    {
        $this->casts[$c_key]['dialougeList'][$d_key]['start'] = date("H:i:s.v", strtotime($this->casts[$c_key]['dialougeList'][$d_key]['start']));
    }

    public function formatEndTime($c_key, $d_key)
    {
        $this->casts[$c_key]['dialougeList'][$d_key]['end'] = date("H:i:s.v", strtotime($this->casts[$c_key]['dialougeList'][$d_key]['end']));
    }

    public function addCastFields()
    {
        $this->casts[] = [
            'name' => '',
            'gender' => '',
            'character' => '',
            'dialougeList' => [
                [
                    'dialouge' => '',
                    'start' => '00:00:00.000',
                    'end' => '00:00:00.000'
                ]
            ]
        ];
    }

    public function removeCastFields($key)
    {
        unset($this->casts[$key]);
        $this->casts = array_values($this->casts);
    }

    public function addDialougeFields($c_key)
    {
        $this->casts[$c_key]['dialougeList'][] = [
            'dialouge' => '',
            'start' => '00:00:00.000',
            'end' => '00:00:00.000'
        ];
    }

    public function removeDialougeFields($c_key, $d_key)
    {
        unset($this->casts[$c_key]['dialougeList'][$d_key]);
        $this->casts[$c_key]['dialougeList'] = array_values($this->casts[$c_key]['dialougeList']);
    }

    public function createMovie()
    {
        $this->validate([
            'movie_name' => 'required',
            'movie_duration' => 'required',
            'casts.*.name' => 'required',
            'casts.*.gender' => 'required',
            'casts.*.character' => 'required|distinct:strict,ignore_case',
            'casts.*.dialougeList.*.dialouge' => 'required',
            // 'casts.*.dialougeList.*.character' => 'required',
            'casts.*.dialougeList.*.start' => 'required|date_format:H:i:s.v|before:casts.*.dialougeList.*.end',
            'casts.*.dialougeList.*.end' => 'required|date_format:H:i:s.v|after:casts.*.dialougeList.*.start'
        ],
        [
            'movie_name.required' => 'Movie name is required.',
            'movie_duration.required' => 'Movie duration is required.',
            'casts.*.name.required' => 'Cast name is required.',
            'casts.*.gender.required' => 'Cast gender is required.',
            'casts.*.character.required' => 'Cast character is required.',
            'casts.*.character.distinct' => 'Cast character field has a duplicate value.',
            'casts.*.dialougeList.*.dialouge.required' => 'Dialouge is required.',
            // 'casts.*.dialougeList.*.character.required' => 'Character is required.',
            'casts.*.dialougeList.*.start.required' => 'Start time is required.',
            'casts.*.dialougeList.*.start.before' => 'Start time must be  a time before end time.',
            'casts.*.dialougeList.*.end.required' => 'End time is required.',
            'casts.*.dialougeList.*.end.after' => 'End time must be a time after start time.'
        ]);

        $create = Movie::create([
            'name' => $this->movie_name,
            'duration' => $this->movie_duration
        ]);

        if($create)
        {
            foreach($this->casts as $c)
            {
                $set = Cast::create([
                    'movie_id' => $create->id,
                    'character_name' => $c['character'],
                    'name' => $c['name'],
                    'gender' => $c['gender']
                ]);

                foreach($c['dialougeList'] as $dl)
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

            return redirect()->route('movies')->with('success', 'New movie created successfully.');
        }
        else
        {
            return redirect()->route('movies')->with('error', 'Something went wrong.');
        }      
    }

    public function resetForm()
    {
        $this->resetErrorBag();
        
        $this->movie_name = $this->movie_duration = '';

        $this->casts = [
            [
                'name' => '',
                'gender' => '',
                'character' => '',
                'dialougeList' => [
                    [
                        'dialouge' => '',
                        'start' => '00:00:00.000',
                        'end' => '00:00:00.000'
                    ]
                ]
            ]
        ];
    }
}