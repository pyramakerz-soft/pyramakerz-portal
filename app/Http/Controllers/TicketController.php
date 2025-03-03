<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'category'   => 'required|in:Technical,Academic,Other',
            'message'    => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,png,pdf,doc,docx|max:2048',
        ]);

        $ticket = new Ticket();
        // Assuming your students are authenticated using a guard (adjust as necessary)
        $ticket->user_id = Auth::guard('student')->id(); 
        $ticket->category = $request->input('category');
        $ticket->message  = $request->input('message');

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('ticket_attachments', 'public');
            $ticket->attachment = $path;
        }

        $ticket->save();

        return response()->json([
            'success' => true,
            'message' => 'Ticket submitted successfully'
        ]);
    }
    public function index()
    {
        $tickets = Ticket::with('user')->orderBy('created_at', 'desc')->get();
        return view('supervisor.tickets', compact('tickets'));
    }

}
