@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Ticket #{{ $ticket->reference_number }}</h4>
                        <form action="{{ route('tickets.update-status', $ticket) }}" method="POST"
                              class="d-flex align-items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <label for="status" class="mb-0">
                                Update Status:
                            </label>
                            <select name="status" class="form-select form-select-sm" style="width: auto;">
                                <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In
                                    Progress
                                </option>
                                <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>
                                    Resolved
                                </option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-primary">
                                Update
                            </button>
                        </form>
                    </div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h5>Customer Information</h5>
                                <p><strong>Name:</strong> {{ $ticket->customer_name }}</p>
                                <p><strong>Email:</strong> {{ $ticket->email }}</p>
                                <p><strong>Phone:</strong> {{ $ticket->phone ?? 'Not provided' }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5>Ticket Details</h5>
                                <p><strong>Status:</strong>
                                    <span class="badge bg-{{
                                        $ticket->status == 'open' ? 'warning' :
                                        ($ticket->status == 'in_progress' ? 'info' :
                                        ($ticket->status == 'resolved' ? 'success' :
                                        ($ticket->status == 'closed' ? 'secondary' : 'primary')))
                                    }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                </p>
                                <p><strong>Created:</strong> {{ $ticket->created_at->format('M d, Y H:i') }}</p>
                                <p><strong>Last Updated:</strong> {{ $ticket->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                        <hr>
                        <h5>Problem Description</h5>
                        <div class="border p-3 bg-light rounded mb-4">
                            {{ $ticket->problem_description }}
                        </div>

                        @if($ticket->replies && $ticket->replies->count() > 0)
                            <h5 class="mt-4 mb-3">Conversation History</h5>
                            <div class="mb-4">
                                @foreach($ticket->replies->sortBy('created_at') as $reply)
                                    <div class="card mb-3">
                                        <div class="card-header d-flex justify-content-between align-items-center
                                            {{ $reply->user_id ? 'bg-primary text-white' : 'bg-light text-dark' }}">
                                            <div>
                                                @if($reply->user_id)
                                                    <span class="fw-bold">
                                                        @if($reply->user)
                                                            {{ $reply->user->name }}
                                                        @else
                                                            Support Agent
                                                        @endif
                                                    </span>
                                                    <span class="badge bg-info ms-2">Agent</span>
                                                @else
                                                    <span class="fw-bold">{{ $ticket->customer_name }}</span>
                                                    <span class="badge bg-success ms-2">Customer</span>
                                                @endif
                                                @if($reply->internal_note)
                                                @endif
                                            </div>
                                            <small>{{ $reply->created_at->format('M d, Y H:i') }}</small>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">{{ $reply->message }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                        @endif
                            <form action="{{ route('agent.tickets.reply', $ticket->id) }}" method="POST" class="mt-4">
                            @csrf
                            <h5>Add Reply</h5>
                            <div class="mb-3">
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror"
                                          rows="3" placeholder="Enter your reply...">{{ old('message') }}</textarea>
                                @error('message')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('agent.dashboard') }}" class="btn btn-secondary">
                                    Back to Dashboard
                                </a>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        Send Reply
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusForm = document.querySelector('form[action*="update-status"]');
            const statusSelect = document.querySelector('select[name="status"]');

            if (statusForm && statusSelect) {
                statusForm.addEventListener('submit', function (e) {
                    const newStatus = statusSelect.value;
                    const currentStatus = '{{ $ticket->status }}';

                    if ((newStatus === 'resolved' || newStatus === 'closed') && newStatus !== currentStatus) {
                        if (!confirm('Are you sure you want to mark this ticket as "' + newStatus + '"? This might notify the customer.')) {
                            e.preventDefault();
                            return;
                        }
                    }
                });
            }
        });
    </script>
@endsection
