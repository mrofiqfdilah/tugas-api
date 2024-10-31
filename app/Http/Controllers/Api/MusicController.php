<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Music;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    public function store(Request $request, $kategoriid, $artisid)
    {



        if ($request->hasFile('music_file')) {
           
            $originalName = $request->file('music_file')->getClientOriginalName();
            
            $musicPath = $request->file('music_file')->storeAs('music', $originalName, 'public');
        } else {
            $musicPath = null; 
        }

        if ($request->hasFile('thumbnail')) {
           
            $originalName = $request->file('thumbnail')->getClientOriginalName();
            
            $thumbnailPath = $request->file('thumbnail')->storeAs('music_thumbnail', $originalName, 'public');
        } else {
            $thumbnailPath = null; 
        }

        $music = new Music;
        $music->kategori_id = $kategoriid;
        $music->artis_id = $artisid;
        $music->nama_music = $request->nama_music;
        $music->music_file = $musicPath;
        $music->thumbnail = $thumbnailPath;
        $music->save();

        return response()->json([
        'message' => 'Add Music Success',
        'data' => [
            'music_name' => $music->nama_music
        ],
        ], 201);
    }

    public function index(Request $request)
    {
        $music = Music::all();

        $format = $music->map(function($data){
            return [
                'nama_music' => $data->nama_music,
                'kategori' => $data->kategori->nama_kategori,
                'music_path' => $data->music_file,
                'artis' => $data->artis->nama_artis
            ];
        });

        return $format;
    }
}
