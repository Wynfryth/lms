<?php

namespace App\Http\Controllers;

use App\Imports\EnrollmentsImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FileUploadController extends Controller
{
    public function uploadEnrollments(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048', // Validate file type and size
        ]);

        try {
            // Import the file
            $import = new EnrollmentsImport();
            Excel::import($import, $request->file('file'));

            // Check for errors
            if ($import->getErrors()) {
                return response()->json(['errors' => $import->getErrors()], 422);
            }

            // Return the valid data as JSON
            return response()->json(['importedParticipants' => $import->getData()], 200);
        } catch (\Exception $e) {
            return response()->json(['errors' => ['Error processing file: ' . $e->getMessage()]], 500);
        }
    }
}
