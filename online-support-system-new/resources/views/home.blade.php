@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mt-4 mt-md-0">
        <div class="col-md-8">
            <div class="card shadow border-0">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4 mb-md-5">
                        <i class="fas fa-headset fa-4x text-primary mb-3" aria-hidden="true"></i>
                        <h1 class="h2 fw-bold">
                            Welcome to Online Support System
                        </h1>
                        <p class="lead text-muted">
                            Get help with your products and services
                        </p>
                    </div>
                    <div class="row g-3 g-md-4">
                        <div class="col-md-6">
                            <div class="card h-100 border-primary">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-plus-circle fa-3x text-primary mb-3" aria-hidden="true"></i>
                                    <h3 class="h4 card-title fw-bold">
                                        Open New Ticket
                                    </h3>
                                    <p class="card-text">
                                        Need assistance? Open a new support ticket.
                                    </p>
                                    <a href="{{ route('tickets.create') }}" class="btn btn-primary btn-lg w-100 mt-3">
                                        Get Help Now
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100 border-success">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-search fa-3x text-success mb-3" aria-hidden="true"></i>
                                    <h3 class="h4 card-title fw-bold">
                                        Check Ticket Status
                                    </h3>
                                    <p class="card-text">
                                        Check your ticket status with reference number.
                                    </p>
                                    <a href="{{ route('tickets.check') }}" class="btn btn-success btn-lg w-100 mt-3">
                                        Check Status
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 mt-md-5 text-center">
                        <h4 class="h5 mb-3">Support Agents</h4>
                        <a href="{{ route('agent.login') }}" class="btn btn-outline-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>Agent Login
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
