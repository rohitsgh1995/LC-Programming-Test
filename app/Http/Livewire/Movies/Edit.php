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
    public $dialougeList = [];

    public function mount($movie_id)
    {
        $this->movie_id = $movie_id;

        try
        {
            $find_movie = Movie::with(['casts', 'dialouges'])->findOrFail($movie_id);

            $this->movie_name = $find_movie->name;
            $this->movie_duration = $find_movie->duration;
            
            foreach($find_movie->casts as $fmc)
            {
                $this->casts[] = [
                    'id' => $fmc->id,
                    'name' => $fmc->name,
                    'gender' => $fmc->gender,
                    'character' => $fmc->character_name
                ];
            }

            foreach($find_movie->dialouges as $fmd)
            {
                $this->dialougeList[] = [
                    'id' => $fmd->id,
                    'dialouge' => $fmd->dialouge,
                    'character' => $fmd->cast->character_name ?? '',
                    'start' => $fmd->start,
                    'end' => $fmd->end
                ];
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
        $this->casts[] = ['id' => '', 'name' => '', 'gender' => '', 'character' => ''];
    }

    public function removeCastField($key)
    {
        if(!empty($this->casts[$key]['id']) && Cast::where('id', $this->casts[$key]['id'])->exists())
        {
            Cast::where('id', $this->casts[$key]['id'])->delete();
        }
        unset($this->casts[$key]);
        $this->casts = array_values($this->casts);
    }

    public function addDialougeFields()
    {
        $this->dialougeList[] = ['id' => '', 'dialouge' => '', 'character' => '', 'start' => '00:00:00.000', 'end' => '00:00:00.000'];
    }

    public function removeDialougeFields($key)
    {
        if(!empty($this->dialougeList[$key]['id']) && Dialouge::where('id', $this->dialougeList[$key]['id'])->exists())
        {
            Dialouge::where('id', $this->dialougeList[$key]['id'])->delete();
        }
        unset($this->dialougeList[$key]);
        $this->dialougeList = array_values($this->dialougeList);
    }

    public function updateMovie()
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
                    Cast::where('id', $c['id'])->where('movie_id', $this->movie_id)->update([
                        'movie_id' => $this->movie_id,
                        'character_name' => $c['character'],
                        'name' => $c['name'],
                        'gender' => $c['gender']
                    ]);

                    foreach($this->dialougeList as $dl)
                    {
                        if(!empty($dl['id']) && Dialouge::where('cast_id', $c['id'])->where('movie_id', $this->movie_id)->exists())
                        {
                            if($dl['character'] === $c['character'])
                            {
                                Dialouge::where('cast_id', $c['id'])->where('movie_id', $this->movie_id)->update([
                                    'movie_id' => $this->movie_id,
                                    'cast_id' => $c['id'],
                                    'dialouge' => $dl['dialouge'],
                                    'start' => $dl['start'],
                                    'end' => $dl['end']
                                ]);
                            }                            
                        }
                        else
                        {
                            if($dl['character'] === $c['character'])
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
                }
                else
                {
                    $set = Cast::create([
                        'movie_id' => $this->movie_id,
                        'character_name' => $c['character'],
                        'name' => $c['name'],
                        'gender' => $c['gender']
                    ]);

                    foreach($this->dialougeList as $dl)
                    {
                        if($dl['character'] === $c['character'])
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
            }

            return redirect()->route('movies')->with('success', 'Movie updated successfully.');
        }
        else
        {
            return redirect()->route('movies')->with('error', 'Something went wrong.');
        }        
    }
}
