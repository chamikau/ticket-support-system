<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Models\Ticket;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    public function index(): View
    {
        return view('home');
    }

    public function createTicket(): View
    {
        return view('tickets.create');
    }

    public function checkTicket(): View
    {
        return view('tickets.check');
    }

    public function showTicketByReference(Request $request)
    {
        $request->validate([
            'reference' => 'required|string'
        ]);

        $ticket = Ticket::where('reference_number', $request->reference)
            ->with(['replies' => function($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->first();

        if (!$ticket) {
            return redirect()->route('tickets.check')
                ->withErrors(['reference' => 'Ticket not found with reference: ' . $request->reference]);
        }

        return view('tickets.show', compact('ticket'));
    }

    public function showTicket(string $reference)
    {
        $ticket = Ticket::where('reference_number', $reference)
            ->with(['replies' => function($query) {
                $query->orderBy('created_at', 'asc');
            }])
            ->first();

        if (!$ticket) {
            abort(404, 'Ticket not found');
        }

        return view('tickets.show', compact('ticket'));
    }

    public function storeTicket(StoreTicketRequest $request)
    {
        $validated = $request->validated();
        $ticket = Ticket::create($validated);

        $emailSent = $this->notificationService->sendTicketCreatedNotification($ticket);
        if ($emailSent) {
            $ticket->update(['notification_sent_at' => now()]);
        }

        return redirect()->route('tickets.show', $ticket->reference_number)
            ->with('success', 'Ticket created successfully! Your reference number: ' . $ticket->reference_number);
    }
}
