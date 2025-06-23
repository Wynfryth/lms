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

    public function upload_pernyataan_persetujuan(Request $request)
    {
        if ($request->hasFile('file_pernyataan_persetujuan')) {
            $filePath = Storage::disk('public')->put('statement_of_consent', request()->file('file_pernyataan_persetujuan'));
            return $filePath;
        }
    }
}
