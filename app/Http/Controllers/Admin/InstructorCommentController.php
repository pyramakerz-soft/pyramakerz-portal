<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstructorComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorCommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'instructor_id' => 'required|exists:users,id',
            'comment' => 'required|string|max:500',
        ]);

        InstructorComment::create([
            'instructor_id' => $request->instructor_id,
            'admin_id' => Auth::guard('admin')->user()->id,
            'comment' => $request->comment,
        ]);

        return response()->json(['message' => 'Comment added successfully!']);
    }

    public function getComments($instructor_id)
    {
        $comments = InstructorComment::where('instructor_id', $instructor_id)
            ->with('admin')
            ->latest()
            ->get();

        return response()->json($comments);
    }
    public function updateComment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
        ]);

        $comment = InstructorComment::findOrFail($id);
        $comment->comment = $request->comment;
        $comment->save();

        return response()->json(['message' => 'Comment updated successfully']);
    }
    public function deleteComment($id)
    {
        $comment = InstructorComment::findOrFail($id);
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
