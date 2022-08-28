<?php

namespace App\Http\Livewire\Movies;

use Livewire\Component;
use App\Models\Movie;
use App\Models\Cast;
use App\Models\Dialouge;

class Edit extends Component
{
    public $movie_id;

    public $movie_name, $movie_duration;
    public $casts = [];
    
    public function mount($movie_id)
    {
        $this->movie_id = $movie_id;

        try
        {
            $find_movie = Movie::with(['casts.dialouges'])->findOrFail($movie_id);

            $this->movie_name = $find_movie->name;
            $this->movie_duration = $find_movie->duration;
            
            foreach($find_movie->casts as $key => $fmc)
            {
                $this->casts[] = [
                    'id' => $fmc->id,
                    'movie_id' => $fmc->movie_id,
                    'name' => $fmc->name,
                    'gender' => $fmc->gender,
                    'character' => $fmc->character_name,
                ];

                foreach($fmc->dialouges as $fmd)
                {
                    $this->casts[$key]['dialougeList'][] = [
                        'id' => $fmd->id,
                        'movie_id' => $fmd->movie_id,
                        'cast_id' => $fmd->cast_id,
                        'dialouge' => $fmd->dialouge,
                        'character' => $fmd->cast->character_name ?? '',
                        'start' => $fmd->start,
                        'end' => $fmd->end
                    ];
                }
            }
        }
        catch (\Exception $e)
        {
            return redirect()->route('movies')->with('error', 'Movie not found.');
        }
    }

    public function render()
    {
        return view('livewire.movies.edit');
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
            'id' => '',
            'movie_id' => '',
            'name' => '',
            'gender' => '',
            'character' => '',
            'dialougeList' => [
                [
                    'id' => '',
                    'movie_id' => '',
                    'cast_id' => '',
                    'dialouge' => '',
                    'start' => '00:00:00.000',
                    'end' => '00:00:00.000'
                ]
            ]
        ];
    }

    public function removeCastFields($key)
    {
        if(!empty($this->casts[$key]['id']) && Cast::where('id', $this->casts[$key]['id'])->exists())
        {
            Cast::where('id', $this->casts[$key]['id'])->delete();
        }
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
        if(!empty($this->casts[$c_key]['dialougeList'][$d_key]['id']) && Dialouge::where('id', $this->casts[$c_key]['dialougeList'][$d_key]['id'])->exists())
        {
            Dialouge::where('id', $this->casts[$c_key]['dialougeList'][$d_key]['id'])->delete();
        }
        unset($this->casts[$c_key]['dialougeList'][$d_key]);
        $this->casts[$c_key]['dialougeList'] = array_values($this->casts[$c_key]['dialougeList']);
    }

    public function updateCast($c_key)
    {
        if(!empty($this->casts[$c_key]['id']) && Cast::where('id', $this->casts[$c_key]['id'])->exists())
        {
            Cast::where('id', $this->casts[$c_key]['id'])->update([
                'character_name' => $this->casts[$c_key]['character'],
                'name' => $this->casts[$c_key]['name'],
                'gender' => $this->casts[$c_key]['gender']
            ]);
        }
    }

    public function updateDialouge($c_key, $d_key)
    {
        if(!empty($this->casts[$c_key]['dialougeList'][$d_key]['id']) && Dialouge::where('id', $this->casts[$c_key]['dialougeList'][$d_key]['id'])->exists())
        {
            Dialouge::where('id', $this->casts[$c_key]['dialougeList'][$d_key]['id'])->update([
                'dialouge' => $this->casts[$c_key]['dialougeList'][$d_key]['dialouge'],
                'start' => date("H:i:s.v", strtotime($this->casts[$c_key]['dialougeList'][$d_key]['start'])),
                'end' => date("H:i:s.v", strtotime($this->casts[$c_key]['dialougeList'][$d_key]['end']))
            ]);
        }
    }

    public function updateMovie()
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

        $update = Movie::where('id', $this->movie_id)->update([
            'name' => $this->movie_name,
            'duration' => $this->movie_duration
        ]);

        if($update)
        {
            foreach($this->casts as $c)
            {
                if(!empty($c['id']) && Cast::where('id', $c['id'])->exists())
                {
                    foreach($c['dialougeList'] as $dl)
                    {
                        if(!empty($dl['id']) && Dialouge::where('id', $dl['id'])->exists())
                        {
                            
                        }
                        else
                        {
                            Dialouge::create([
                                'movie_id' => $this->movie_id,
                                'cast_id' => $c['id'],
                                'dialouge' => $dl['dialouge'],
                                'start' => $dl['start'],
                                'end' => $dl['end']
                            ]);
                        }
                    }                    
                }
                else
                {
                    $set = Cast::create([
                        'movie_id' => $this->movie_id,
                        'character_name' => $c['character'],
                        'name' => $c['name'],
                        'gender' => $c['gender']
                    ]);
    
                    foreach($c['dialougeList'] as $dl)
                    {
                        Dialouge::create([
                            'movie_id' => $this->movie_id,
                            'cast_id' => $set->id,
                            'dialouge' => $dl['dialouge'],
                            'start' => $dl['start'],
                            'end' => $dl['end']
                        ]);
                    }
                }                
            }

            return redirect()->route('movies')->with('success', 'Movie updated successfully.');
        }
        else
        {
            return redirect()->route('movies')->with('error', 'Something went wrong.');
        }
    }
}
