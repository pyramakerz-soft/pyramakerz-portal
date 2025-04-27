<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class InstructorsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['name']) || !isset($row['email']) || !isset($row['password'])) {
            return null;
        }

        if (User::where('email', $row['email'])->exists()) {
            return null;
        }

        $instructor = new User([
            'name'        => $row['name'],
            'email'       => $row['email'],
            'phone'       => $row['phone'] ?? null,
            'governorate' => $row['governorate'] ?? null,
            'password'    => Hash::make($row['password']),
            'role'        => 'teacher',
            'level'        => $row['level'] ?? null,
            'salary_type'  => $row['salary_type'] ?? null,
            'salary'       => $row['salary'] ?? null,

        ]);
        $instructor->assignRole('instructor');


        return $instructor;
    }
}
