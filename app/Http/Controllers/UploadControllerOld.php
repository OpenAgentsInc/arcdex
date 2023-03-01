<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $file = $request->file('file');
        
        $timestamp = now()->format('Y-m-d-H-i-s');

        $filename = "{$timestamp}-{$file->getClientOriginalName()}";

        Storage::disk('public')->putFileAs("uploads", $file, $filename);

        return parse_url(Storage::disk('public')->url("uploads/{$filename}"), PHP_URL_PATH);
    }
}
