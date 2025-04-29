<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Support\Str;

class StudentsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $studentsToInsert = [];

        foreach ($rows as $row) {
            // Remove spaces from the name
            $cleanName = str_replace(' ', '', $row['name']);

            // Extract the first 4 digits of the phone number
            $phonePrefix = substr($row['phone'], 0, 4);

            // Generate custom email format
            $generatedEmail = strtolower($cleanName) . $phonePrefix . '@alpha.com';

            // Check if student already exists by email or phone
            $exists = Student::where('email', $generatedEmail)
                ->orWhere('phone', $row['phone'])
                ->exists();

            if (!$exists) {
                $studentsToInsert[] = [
                    'name'         => $row['name'],
                    'email'        => $generatedEmail,
                    'phone'        => $row['phone'],
                    'parent_phone' => $row['parent_phone'],
                    'country'      => $row['country'],
                    'city'         => $row['city'],
                    'school'       => $row['school'],
                    'gender'       => $row['gender'],
                    'bday'         => $this->convertToDate($row['bday']),
                    'year'         => $row['year'],
                    'password'     => Hash::make('password'),
                    'created_at'   => now(),
                    'updated_at'   => now(),
                    'code'         => $this->generateStudentCode(),
                ];
            }
        }

        // Bulk Insert all non-duplicate students at once
        if (!empty($studentsToInsert)) {
            Student::insert($studentsToInsert);
        }
    }


    private function convertToDate($value)
    {
        // Check if value is numeric (Excel date format)
        if (is_numeric($value)) {
            return Carbon::createFromFormat('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d'));
        }

        // Handle string dates (e.g., '06/03/1997' or '06-03-1997')
        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null; // Handle invalid date formats gracefully
        }
    }
    private function generateStudentCode()
    {
        do {
            $code = 'STU-' . strtoupper(Str::random(6));
        } while (Student::where('code', $code)->exists());

        return $code;
    }
}
