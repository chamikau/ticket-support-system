<!DOCTYPE html>
<html>
<head>
    <title>Support Ticket Created</title>
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
            border-radius: 5px;
        }
        .content {
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
            margin-top: 20px;
        }
        .ticket-info {
            background: white;
            padding: 15px;
            border-left: 4px solid #4F46E5;
            margin: 15px 0;
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
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Support Ticket Created</h1>
</div>

<div class="content">
    <p>Hello <strong>{{ $ticket->customer_name }}</strong>,</p>

    <p>Thank you for contacting our support team. We have received your request and will get back to you shortly.</p>

    <div class="ticket-info">
        <h3>Ticket Details</h3>
        <p><strong>Reference Number:</strong> {{ $ticket->reference_number }}</p>
        <p><strong>Date Submitted:</strong> {{ $ticket->created_at->format('F d, Y \a\t h:i A') }}</p>
        <p><strong>Status:</strong> Open</p>
        <p><strong>Description:</strong> {{ $ticket->problem_description }}</p>
    </div>

    <p><strong>Important:</strong> Please save your reference number to check the status of your ticket.</p>

    <p>You can check your ticket status anytime by visiting:</p>

    <a href="{{ url('/tickets/check') }}" class="btn">Check Ticket Status</a>

    <p>Or use this direct link: {{ url('/tickets/' . $ticket->reference_number) }}</p>

    <p>Our support team will review your request and respond within 24 hours.</p>
</div>

<div class="footer">
    <p>This is an automated message. Please do not reply to this email.</p>
    <p>&copy; {{ date('Y') }} {{ config('app.name', 'Support System') }}</p>
</div>
</body>
</html>
