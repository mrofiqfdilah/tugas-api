<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $kategori = Kategori::all();

        $pattern = $kategori->map(function($data) {
            return [
                'category_name' => $data->nama_kategori,
                'logo_path' => $data->logo_kategori
            ];
        });

        return response()->json([
        'message' => 'Get All Category Success',
        'data' => $pattern
        ], 200);
    }

    public function store(Request $request)
    {
        if ($request->hasFile('logo_kategori')) {
           
            $originalName = $request->file('logo_kategori')->getClientOriginalName();
            
            $imagePath = $request->file('logo_kategori')->storeAs('category_logo', $originalName, 'public');
        } else {
            $imagePath = null; 
        }

        $kategori = new Kategori;
        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->logo_kategori = $imagePath;
        $kategori->save();

        return response()->json([
        'message' => 'Create Category Success',
        'data' => [
            'category_name' =>$kategori->nama_kategori,
            'logo_path' => $kategori->logo_kategori 
        ]
        ], 201);
    }
}
