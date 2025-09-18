<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function show() {
        return Movie::all();
    }
    
    public function index($id) {
        $movie = Movie::findOrFail($id);
        return response()->json($movie);
    }

    public function store(Request $request) {
        $validated = $request->validate(
            [
                'title'=>'required|string|max:255',
                'description'=>'required|string|min:8',
                'language'=>'required|string',
                'release_year'=>'required|digits:4|integer|min:1888|max:'.date('Y') ,
            ]
        );
        $movie = Movie::create($validated);
        return response()->json($movie);

    }

    public function update(Request $request, $id) {
        $movie = Movie::findOrFail($id);
        $validated = $request->validate([
            'title'=>'sometimes|string|max:255',
            'description'=>'sometimes|string|min:8',
            'language'=>'sometimes|string|max:10',
            'release_year'=>'sometimes|digits:4|integer|min:1888|max:'.date('Y') ,            
        ]);
        $movie->update($validated);
        return response()->json($movie);

    }

    public function destroy($id) {
        $movie = Movie::findOrFail($id);
        $movie->delete();
        return response()->json(null, 204);
    }

    
}
