<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:5120', 
        ]);

        $path = $request->file('file')->store('uploads', 'public');

        return response()->json(['path' => $path, 'message' => 'File uploaded successfully!']);
    }
}
