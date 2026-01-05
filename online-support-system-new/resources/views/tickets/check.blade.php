@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0"><i class="fas fa-search me-2"></i>Check Ticket Status</h4>
                </div>
                <div class="card-body p-4">
                    <!-- Change from GET to POST or keep GET with correct action -->
                    <form action="{{ route('tickets.show-by-reference') }}" method="GET">
                        <div class="mb-4">
                            <label for="reference_number" class="form-label">Enter Your Reference Number *</label>
                            <input type="text" class="form-control @error('reference') is-invalid @enderror"
                                   id="reference_number" name="reference"
                                   value="{{ old('reference') }}"
                                   placeholder="e.g., TICKET-ABC123XYZ" required>
                            @error('reference')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-search me-2"></i>Check Status
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Home
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
