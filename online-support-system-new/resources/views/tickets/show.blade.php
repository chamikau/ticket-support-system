@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @if(!isset($ticket) || !$ticket)
                    <div class="alert alert-danger">
                        Ticket not found. Please check your reference number.
                    </div>
                    <div class="text-center">
                        <a href="{{ route('tickets.check') }}" class="btn btn-primary">Check Another Ticket</a>
                    </div>
                @else
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0">Ticket: {{ $ticket->reference_number }}</h5>
                                <small class="text-muted">Status:
                                    <span class="badge bg-{{ $ticket->status == 'open' ? 'warning' : ($ticket->status == 'resolved' ? 'success' : 'primary') }}">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </small>
                            </div>
                            <a href="{{ route('tickets.check') }}" class="btn btn-sm btn-outline-primary">Check Another</a>
                        </div>

                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6>Customer Information</h6>
                                    <p><strong>Name:</strong> {{ $ticket->customer_name }}</p>
                                    <p><strong>Email:</strong> {{ $ticket->email }}</p>
                                    <p><strong>Phone:</strong> {{ $ticket->phone ?? 'Not provided' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Ticket Details</h6>
                                    <p><strong>Created:</strong> {{ $ticket->created_at->format('M d, Y H:i') }}</p>
                                    <p><strong>Last Updated:</strong> {{ $ticket->updated_at->format('M d, Y H:i') }}</p>
                                    @if(isset($ticket->agent) && $ticket->agent)
                                        <p><strong>Assigned Agent:</strong> {{ $ticket->agent->name }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6>Problem Description</h6>
                                <div class="border p-3 bg-light">
                                    {{ $ticket->problem_description }}
                                </div>
                            </div>

                            <div class="mb-4">
                                <h6>Agent Replies</h6>

                                @if($ticket->replies->count() > 0)
                                    @foreach($ticket->replies as $reply)
                                        @if($reply->user_id)  <!-- Only show agent replies -->
                                        <div class="card mb-3">
                                            <div class="card-header bg-primary text-white d-flex justify-content-between">
                                                    <span>
                                                        @if(isset($reply->user))
                                                            {{ $reply->user->name }} (Agent)
                                                        @else
                                                            Support Agent
                                                        @endif
                                                    </span>
                                                <small>{{ $reply->created_at->format('M d, Y H:i') }}</small>
                                            </div>
                                            <div class="card-body">
                                                {{ $reply->message }}
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="alert alert-info">
                                        No agent replies yet. Our support team will get back to you soon.
                                    </div>
                                @endif
                            </div>

                            <div class="text-center">
                                <a href="{{ route('tickets.create') }}" class="btn btn-primary">Open New Ticket</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
