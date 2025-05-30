<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function store(Request $request)
    {



        // Handle file upload logic here
        // Validate the request, store the file, etc.

        return response()->json(['message' => 'File uploaded successfully'], 201);
    }
}
