<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function index()
    {
        $instructors = User::where('role', 'teacher')
            ->with(['courses'])
            ->get();

        return view('supervisor.index', compact('instructors'));
    }
}
