<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function upload_study_attachment(Request $request)
    {
        if ($request->hasFile('file_pembelajaran')) {
            $filePath = Storage::disk('public')->put('study_attachment', request()->file('file_pembelajaran'));
            return $filePath;
        }
    }
}
