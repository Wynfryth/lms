<?php

namespace App\Imports;

use App\Models\Enrollments;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Log;

class EnrollmentsImport implements ToCollection, WithHeadingRow
{
    public $data;
    public $errors = [];

    public function collection(Collection $rows)
    {
        // Validate the header row
        $headers = array_keys($rows->first()->toArray());

        if (count($headers) !== 1 || $headers[0] !== 'nip') {
            $this->errors[] = 'The file must contain only one column named "NIP".';
            return;
        }

        // Store rows
        $this->data = $rows->toArray();
    }

    public function getData()
    {
        return $this->data;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
