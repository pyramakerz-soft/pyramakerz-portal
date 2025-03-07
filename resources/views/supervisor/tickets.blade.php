<!doctype html>
<html class="no-js" lang="zxx">
@include('include.head')

<body class="body__wrapper">
    @include('include.load')

    <main class="main_wrapper overflow-hidden">
        @include('include.dash-nav')

        <div class="dashboardarea sp_bottom_100">
        @include('include.admin-topbar')

            <div class="container-fluid full__width__padding">
                <div class="row">
                    <!-- Sidebar -->
                    <div class="col-xl-3 col-lg-3 col-md-12">
                        @include('include.sidebar')
                    </div>

                    <!-- Main Content -->
                    <div class="col-xl-9 col-lg-9 col-md-12">
                        <div class="dashboard__content__wraper">
                            <div class="dashboard__section__title">
                                <h4>📋 Support Tickets</h4>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="headtb text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Category</th>
                                            <th>Message</th>
                                            <th>Attachment</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tickets as $index => $ticket)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $ticket->user->name }}</td>
                                                <td>
                                                    <span class="badge 
                                                        {{ $ticket->category === 'Technical' ? 'bg-success' : ($ticket->category === 'Academic' ? 'bg-success' : 'bg-warning') }}">
                                                        {{ ucfirst($ticket->category) }}
                                                    </span>
                                                </td>
                                                <td>{{ Str::limit($ticket->message, 50) }}</td>
                                                <td>
                                                    @if ($ticket->attachment)
                                                        <a href="{{ asset($ticket->attachment) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                                            View
                                                        </a>
                                                    @else
                                                        No Attachment
                                                    @endif
                                                </td>
                                                <td>{{ $ticket->created_at->format('d M Y, h:i A') }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary view-ticket-btn"
                                                        data-message="{{ $ticket->message }}"
                                                        data-attachment="{{ $ticket->attachment ? asset( $ticket->attachment) : '' }}">
                                                        <i class="icofont-eye"></i> View
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($tickets->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center">No Tickets Available.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            {{-- <div class="mt-3">
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                    <i class="icofont-arrow-left"></i> Back to Dashboard
                                </a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('include.scripts')
    </main>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $(".view-ticket-btn").click(function () {
                let message = $(this).data("message");
                let attachment = $(this).data("attachment");
                let attachmentHtml = attachment
                    ? `<p><a href="${attachment}" target="_blank" class="btn btn-info">View Attachment</a></p>`
                    : "<p>No Attachment</p>";

                Swal.fire({
                    title: "Ticket Details",
                    html: `<p><strong>Message:</strong> ${message}</p>${attachmentHtml}`,
                    icon: "info",
                });
            });
        });
    </script>
</body>
</html>
