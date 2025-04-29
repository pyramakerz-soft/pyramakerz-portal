<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use Illuminate\Support\Str;

class GenerateStudentCodes extends Command
{
    protected $signature = 'students:generate-codes';
    protected $description = 'Generate unique codes for existing students without a code';

    public function handle()
    {
        $students = Student::whereNull('code')->get();
        $count = 0;

        foreach ($students as $student) {
            do {
                $code = 'STU-' . strtoupper(Str::random(6));
            } while (Student::where('code', $code)->exists());

            $student->code = $code;
            $student->save();
            $count++;
        }

        $this->info("✅ Successfully assigned codes to {$count} students.");
    }
}
