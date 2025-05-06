<?php

namespace App\Exports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentsTemplateExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Student::select([
            'code',
            'name',
            'email',
            'phone',
            'parent_phone',
            'country',
            'city',
            'school',
            'gender',
            'bday',
            'year',
        ])->get();
    }

    public function headings(): array
    {
        return [
            'Code',
            'Name',
            'Email',
            'Phone',
            'Parent Phone',
            'Country',
            'City',
            'School',
            'Gender',
            'Birthday',
            'Year',
        ];
    }
}
