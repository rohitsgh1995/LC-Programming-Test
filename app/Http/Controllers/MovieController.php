<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::with(['casts', 'dialouges'])->orderBy('id', 'desc')->get();
        
        return view('movies.index', compact('movies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('movies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'movieName' => 'required',
            'movieDuration' => 'required',
            'cast.*.name' => 'required',
            'cast.*.gender' => 'required',
            'cast.*.character' => 'required',
        ],
        [
            'movieName.required' => 'Movie name is required.',
            'movieDuration.required' => 'Movie duration is required.',
            'cast.*.name.required' => 'Cast name is required.',
            'cast.*.gender.required' => 'Cast gender is required.',
            'cast.*.character.required' => 'Cast character is required.',
        ]);
        
        $create = Movie::create([
            'name' => $request->movieName,
            'duration' => $request->movieDuration
        ]);     

        return redirect()->route('movies')->with('success', 'New movie created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        //
    }
}
