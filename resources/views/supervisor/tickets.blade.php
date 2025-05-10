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
                            <!-- Filters -->
                            <form method="GET" action="{{ route('admin.tickets') }}" class="mb-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="status" class="form-control">
                                            <option value="">Filter by Status</option>
                                            <option value="unresolved" {{ request('status') == 'unresolved' ? 'selected' : '' }}>Unresolved</option>
                                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="category" class="form-control">
                                            <option value="">Filter by Category</option>
                                            <option value="Academic" {{ request('category') == 'Academic' ? 'selected' : '' }}>Academic</option>
                                            <option value="Technical" {{ request('category') == 'Technical' ? 'selected' : '' }}>Technical</option>
                                            <option value="Administrative" {{ request('category') == 'Administrative' ? 'selected' : '' }}>Administrative</option>
                                            <option value="Other" {{ request('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-warning default__small__button mt-2 w-100">Apply Filters</button>
                                    </div>
                                </div>
                            </form>


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
                                            <th>Status</th>
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
                                            <td>{{ $ticket->status }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-black view-ticket-btn"
                                                    data-message="{{ $ticket->message }}"
                                                    data-attachment="{{ $ticket->attachment ? asset( $ticket->attachment) : '' }}">
                                                    <i class="icofont-eye"></i> View
                                                </button>
                                                @if (Auth::guard('admin')->user()->roles[0]->name != 'instructor')
                                                <a href="{{ route('admin.change_ticket_status', $ticket->id) }}"
                                                    data-url="{{ route('admin.change_ticket_status', $ticket->id) }}"
                                                    class="btn btn-sm btn-black change-status-btn">
                                                    <i class="icofont-eye"></i> Change Status
                                                </a>
                                                @endif
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
        $(document).on("click", ".change-status-btn", function(e) {
            e.preventDefault();

            const url = $(this).data("url");

            Swal.fire({
                title: "Alert!",
                text: "Are you sure you want to change status of this ticket?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Status Changed!",
                                text: "Status changed successfully!",
                                icon: "success",
                                confirmButtonColor: "#ff7918"
                            }).then(() => location.reload());
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Error",
                                text: xhr.responseJSON?.message || "Failed to update status!",
                                icon: "error",
                                confirmButtonColor: "#ff7918"
                            });
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".view-ticket-btn").click(function() {
                let message = $(this).data("message");
                let attachment = $(this).data("attachment");
                let attachmentHtml = attachment ?
                    `<p><a href="${attachment}" target="_blank" class="btn btn-info" style='color: #545454;'>View Attachment</a></p>` :
                    "<p style='color: #545454;' >No Attachment</p>";
                Swal.fire({
                    title: "Ticket Details",
                    html: `<p style="color: #545454;"><strong>Message:</strong> ${message}</p>${attachmentHtml}`,
                    icon: "info",
                });
            });
        });
    </script>
</body>

</html>