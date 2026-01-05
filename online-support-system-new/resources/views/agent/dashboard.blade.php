@extends('layouts.dashboard')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <nav id="side-nav-bar" class="col-md-3 col-lg-2 d-md-block bg-light side-nav-bar collapse">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('agent.dashboard') }}">
                                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                            </a>
                        </li>
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" href="{{ route('agent.tickets.pending') }}">--}}
{{--                                <i class="fas fa-clock me-2"></i>Pending Tickets--}}
{{--                            </a>--}}
{{--                        </li>--}}
                        <li class="nav-item">
                            <hr class="dropdown-divider">
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('agent.logout') }}">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link text-start w-100">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div
                    class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Support Dashboard</h1>
                </div>
                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-start border-primary border-4 shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">
                                            Open Tickets
                                        </div>
                                        <div class="h5 mb-0 fw-bold text-gray-800" id="openTicketsCount">0</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-inbox fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-start border-warning border-4 shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs fw-bold text-warning text-uppercase mb-1">
                                            In Progress
                                        </div>
                                        <div class="h5 mb-0 fw-bold text-gray-800" id="progressTicketsCount">0</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-spinner fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-start border-success border-4 shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs fw-bold text-success text-uppercase mb-1">
                                            Resolved Tickets
                                        </div>
                                        <div class="h5 mb-0 fw-bold text-gray-800" id="resolvedCount">0</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-start border-info border-4 shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs fw-bold text-info text-uppercase mb-1">
                                            Total Tickets
                                        </div>
                                        <div class="h5 mb-0 fw-bold text-gray-800" id="totalTicketsCount">0</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold text-primary">Recent Tickets</h6>
                        <div class="input-group" style="width: 300px;">
                            <input type="text" class="form-control" placeholder="Search customer..." id="searchInput">
                            <button class="btn btn-outline-primary" type="button" id="searchBtn">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" id="ticketsTableContainer">
                            <div class="text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .side-nav-bar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

        .side-nav-bar .nav-link {
            font-weight: 500;
            color: #333;
            padding: 0.75rem 1rem;
        }

        .side-nav-bar .nav-link.active {
            color: #2470dc;
            background-color: #e7f1ff;
        }

        .side-nav-bar .nav-link:hover {
            color: #2470dc;
            background-color: #f8f9fa;
        }

        .status-new {
            background-color: #ffc107;
            color: #000;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function () {
            let currentPage = 1;
            loadTickets();
            loadTicketStatus();
            $('#refreshBtn').click(function () {
                loadTickets();
                loadTicketStatus();
            });
            $('#searchBtn').click(function () {
                currentPage = 1;
                loadTickets();
            });
            $('#searchInput').keypress(function (e) {
                if (e.which === 13) {
                    currentPage = 1;
                    loadTickets();
                }
            });

            function loadTickets() {
                const search = $('#searchInput').val();

                $.ajax({
                    url: '{{ route("agent.tickets.index") }}',
                    method: 'GET',
                    data: {
                        page: currentPage,
                        search: search
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        renderTicketsTable(response);
                    },
                    error: function () {
                        $('#ticketsTableContainer').html(
                            '<div class="alert alert-danger">Error loading tickets. Please try again.</div>'
                        );
                    }
                });
            }

            function loadTicketStatus() {
                $.ajax({
                    url: '{{ route("agent.ticket-status") }}',
                    method: 'GET',
                    success: function (response) {
                        $('#openTicketsCount').text(response.open_tickets);
                        $('#progressTicketsCount').text(response.in_progress);
                        $('#resolvedCount').text(response.resolved);
                        $('#totalTicketsCount').text(response.total_tickets);
                    }
                });
            }

            function renderTicketsTable(data) {
                let html = `
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Reference</th>
                            <th>Customer</th>
                            <th>Problem</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>`;

                if (data.data.length === 0) {
                    html += `
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                            <p class="text-muted">No tickets found.</p>
                        </td>
                    </tr>`;
                } else {
                    data.data.forEach(function (ticket) {
                        const isNew = ticket.status === 'open' && !ticket.agent_id;
                        const statusClass = ticket.status === 'open' ? 'badge bg-warning' :
                            ticket.status === 'in_progress' ? 'badge bg-primary' :
                                'badge bg-success';

                        html += `
                        <tr class="${isNew ? 'table-warning' : ''}">
                            <td>
                                <strong>${ticket.reference_number}</strong>
                                ${isNew ? '<span class="status-new badge ms-2">NEW</span>' : ''}
                            </td>
                            <td>
                                <div>${ticket.customer_name}</div>
                                <small class="text-muted">${ticket.email}</small>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 200px;"
                                     title="${ticket.problem_description}">
                                    ${ticket.problem_description}
                                </div>
                            </td>
                            <td><span class="${statusClass}">${ticket.status}</span></td>
                            <td>${new Date(ticket.created_at).toLocaleDateString()}</td>
                            <td>
                                <a href="/agent/tickets/${ticket.id}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>`;
                    });
                }

                html += `</tbody></table>`;
                // add pagination
                if (data.pagination && data.pagination.total_pages > 1) {
                    html += renderPagination(data.pagination);
                }
                $('#ticketsTableContainer').html(html);
                $('.page-link').click(function (e) {
                    e.preventDefault();
                    currentPage = $(this).data('page');
                    loadTickets();
                });
            }

            function renderPagination(pagination) {
                let html = `
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">`;
                html += `
                <li class="page-item ${pagination.current_page === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${pagination.current_page - 1}">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>`;
                for (let i = 1; i <= pagination.total_pages; i++) {
                    html += `
                    <li class="page-item ${pagination.current_page === i ? 'active' : ''}">
                        <a class="page-link" href="#" data-page="${i}">${i}</a>
                    </li>`;
                }
                html += `
                <li class="page-item ${pagination.current_page === pagination.total_pages ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${pagination.current_page + 1}">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>`;

                html += `</ul></nav>`;
                return html;
            }

            setInterval(function () {
                loadTickets();
            }, 30000);
        });
    </script>
@endpush
