<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Group;
use Illuminate\Support\Str;

class GenerateGroupCodes extends Command
{
    protected $signature = 'groups:generate-codes';
    protected $description = 'Generate unique codes for existing groups without a code';

    public function handle()
    {
        $groups = Group::whereNull('code')->get();
        $count = 0;

        foreach ($groups as $group) {
            do {
                $code = 'pyra-' . strtoupper(Str::random(6));
            } while (Group::where('code', $code)->exists());

            $group->code = $code;
            $group->save();
            $count++;
        }

        $this->info("✅ Successfully assigned codes to {$count} groups.");
    }
}
