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

            $imageName = time() . '.' . request()->attachment->getClientOriginalExtension();
            request()->attachment->move(public_path('ticket_attachments'), $imageName);
            $ticket->attachment = 'ticket_attachments/' . $imageName;
        }

        $ticket->save();

        return response()->json([
            'success' => true,
            'message' => 'Ticket submitted successfully'
        ]);
    }
    public function index(Request $request)
    {
        $query = Ticket::query();
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->filled('category')) {
            // dd($query->get());
            $query->where('category', $request->input('category'));
        }
        $tickets = $query->with('user')->orderBy('created_at', 'desc')->get();
        return view('supervisor.tickets', compact('tickets'));
    }
    public function changeStatus($id)
    {
        $ticket = Ticket::find($id);
        if ($ticket) {
            $ticket->status = $ticket->status == 'unresolved' ? 'resolved' : 'unresolved';
            $ticket->save();
            return response()->json(['success' => true, 'message' => 'Ticket status updated successfully']);
        }
        return response()->json(['success' => false, 'message' => 'Ticket not found']);
    }
}
