<?php

namespace App\Http\Controllers;

class MahasiswaController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function getData()
    {
        $path = storage_path('app/data/mahasiswa.json');

        if (!file_exists($path)) {
            return response()->json([
                'message' => 'File JSON tidak ditemukan'
            ], 404);
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return response()->json([
                'message' => 'Format JSON tidak valid'
            ], 500);
        }

        return response()->json($data);
    }
}