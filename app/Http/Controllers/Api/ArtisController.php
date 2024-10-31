<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artis;

class ArtisController extends Controller
{
    public function index(Request $request)
    {
        $artis = Artis::all();

        $pattern = $artis->map(function($data) {
            return [
                'artist_name' => $data->nama_artis,
                'artist_image' => $data->gambar_artis
            ];
        });

        return response()->json([
        'message' => 'Get All Artist Success',
        'data' => $pattern
        ], 200);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('gambar_artis')) {
           
            $originalName = $request->file('gambar_artis')->getClientOriginalName();
            
            $imagePath = $request->file('gambar_artis')->storeAs('artist_image', $originalName, 'public');
        } else {
            $imagePath = null; 
        }

        $artis = new Artis;
        $artis->nama_artis = $request->nama_artis;
        $artis->gambar_artis = $imagePath;
        $artis->save();

        return response()->json([
        'message' => 'Create Artist Success',
        'data' => [
            'artist_name' => $artis->nama_artis,
            'artist_image' => $artis->gambar_artis
        ]
        ], 201);
    }
}
