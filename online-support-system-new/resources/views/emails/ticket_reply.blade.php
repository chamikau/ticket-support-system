<!DOCTYPE html>
<html>
<head>
    <title>Ticket Reply Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #4F46E5;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .ticket-info {
            background: white;
            padding: 15px;
            border-left: 4px solid #4F46E5;
            margin: 15px 0;
        }
        .reply-box {
            background: #e8f4fd;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            color: #666;
            font-size: 12px;
        }
        .btn {
            display: inline-block;
            background: #4F46E5;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Support Ticket Update</h1>
</div>

<div class="content">
    <p>Hello <strong>{{ $ticket->customer_name }}</strong>,</p>

    <p>Our support team has replied to your ticket:</p>

    <div class="ticket-info">
        <h3>Ticket Details</h3>
        <p><strong>Ticket #:</strong> {{ $ticket->reference_number }}</p>
        <p><strong>Subject:</strong> Support Request</p>
        <p><strong>Status:</strong> {{ ucfirst($ticket->status) }}</p>
    </div>

    <div class="reply-box">
        <h3>Support Agent's Reply:</h3>
        <p>{{ $reply->message }}</p>
        <p><em>Replied on: {{ $reply->created_at->format('F d, Y \a\t h:i A') }}</em></p>
    </div>

    <p>You can view your ticket and reply by clicking the button below:</p>

    <a href="{{ url('/tickets/' . $ticket->reference_number) }}" class="btn">
        View Your Ticket
    </a>

    <p>If the button doesn't work, copy and paste this link:</p>
    <p>{{ url('/tickets/' . $ticket->reference_number) }}</p>
</div>

<div class="footer">
    <p>This is an automated message. Please do not reply to this email.</p>
    <p>&copy; {{ date('Y') }} {{ config('app.name', 'Support System') }}</p>
</div>
</body>
</html>
