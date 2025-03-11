<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\FromArray;

class StudentsTemplateExport implements FromArray
{
    public function array(): array
    {
        return [
            ['name', 'email', 'phone', 'parent_phone', 'country', 'city', 'school', 'gender', 'bday', 'year']
        ];
    }
}

