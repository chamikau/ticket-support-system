<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketReplyRequest;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AgentTicketController extends Controller
{
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function index(Request $request)
    {
        $query = Ticket::query();

        if ($request->search) {
            $search = $request->search;
            $query->where('customer_name', 'like', '%' . $search . '%');
        }

        $tickets = $query->orderBy('created_at', 'desc')->paginate(10);

        if ($request->ajax()) {
            return response()->json([
                'data' => $tickets->map(function($ticket) {
                    return [
                        'id' => $ticket->id,
                        'reference_number' => $ticket->reference_number,
                        'customer_name' => $ticket->customer_name,
                        'email' => $ticket->email,
                        'problem_description' => $ticket->problem_description,
                        'status' => $ticket->status,
                        'created_at' => $ticket->created_at->format('Y-m-d H:i:s'),
                    ];
                }),
                'pagination' => [
                    'current_page' => $tickets->currentPage(),
                    'total_pages' => $tickets->lastPage(),
                ]
            ]);
        }

        return view('agent.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->status == 'new') {
            $ticket->update([
                'status' => 'in_progress',
                'agent_id' => Auth::id(),
                'opened_at' => now(),
            ]);
        }

        return view('agent.ticket-show', compact('ticket'));
    }

    public function reply(TicketReplyRequest $request, Ticket $ticket)
    {
        $validated = $request->validated();

        $reply = TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => Auth::id(),
            'message' => $validated['message'],
        ]);

        $emailSent = $this->notificationService->sendTicketReplyNotification($ticket, $reply);

        if ($emailSent) {
            $reply->update(['notification_sent_at' => now()]);
        }
        return redirect()->back()->with('success', 'Reply sent successfully.');
    }
    public function ticketStatus()
    {
        try {
            return response()->json([
                'total_tickets' => Ticket::count(),
                'open_tickets' => Ticket::where('status', 'new')->count(),
                'in_progress' => Ticket::where('status', 'in_progress')->count(),
                'resolved' => Ticket::where('status', 'resolved')->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'total_tickets' => 0,
                'open_tickets' => 0,
                'in_progress' => 0,
                'resolved_today' => 0,
            ]);
        }
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:in_progress,resolved'
        ]);
        $newStatus = (string) $request->status;

        $ticket->update([
            'status' => $newStatus,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Ticket status updated to ' . ucfirst($newStatus));
    }
}
