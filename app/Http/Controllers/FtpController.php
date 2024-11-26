<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class FtpController extends Controller
{
    public function index()
    {
        $folders = Storage::directories('uploads/guests');

        $allFiles = [];
        foreach ($folders as $folder) {
            $files = Storage::files($folder);
            $allFiles = array_merge($allFiles, $files);
        }
        return Inertia::render('FTP/Index', [
            'files' =>  $allFiles,
        ]);
    }

    public function show($id, Request $request)
    {
        $path = $request->toArray()[$id];
        if (Storage::exists($path)) {
            return Storage::download($path);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }
    }

    public function destroy($id, Request $request)
    {
        $path = $request->toArray()[$id];
        if (Storage::exists($path)) {
             Storage::delete($path);
        }
    }
}
