<?php

namespace App\Services;

use App\Mail\TicketCreatedMail;
use App\Mail\TicketReplyMail;
use App\Models\Ticket;
use App\Mail\TicketReplySent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    public function sendTicketCreatedNotification(Ticket $ticket): void
    {
        try {
            Mail::to($ticket->email)->send(new TicketCreatedMail($ticket));
        } catch (\Exception $e) {
            Log::error('Failed to send ticket creation email: ' . $e->getMessage());
        }
    }

    public function sendTicketReplyNotification(Ticket $ticket, $reply): bool
    {
        try {
            $mail = new TicketReplyMail($ticket, $reply);
            Mail::to($ticket->email)->send($mail);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send reply to recipient: ' . $e->getMessage());
            return false;
        }
    }
}
