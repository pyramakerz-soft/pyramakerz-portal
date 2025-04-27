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
                                <h4>📋 Enrollment Requests</h4>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="headtb text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>Student Name</th>
                                            <th>Course</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($enrollments as $index => $enrollment)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $enrollment->student->name }}</td>
                                            <td>{{ $enrollment->course->name }}</td>
                                            <td>
                                                <span class="badge {{ $enrollment->status === 'pending' ? 'bg-warning' : ($enrollment->status === 'approved' ? 'bg-success' : 'bg-danger') }}">
                                                    {{ ucfirst($enrollment->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($enrollment->status === 'pending')
                                                <button class="btn btn-sm btn-success approve-btn" data-id="{{ $enrollment->id }}">
                                                    <i class="icofont-check"></i> Approve
                                                </button>
                                                <button class="btn btn-sm btn-danger reject-btn" data-id="{{ $enrollment->id }}">
                                                    <i class="icofont-close"></i> Reject
                                                </button>
                                                @else
                                                <span class="text-muted">No Actions</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        @if ($enrollments->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">No Enrollment Requests Available.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                @if(Auth::guard('admin')->user())
                                @if(Auth::guard('admin')->user()->roles[0]->name == 'admin' || Auth::guard('admin')->user()->roles[0]->name == 'supervisor')
                                <a href="{{ route('admin.instructors.index') }}" class="btn btn-outline-secondary">
                                    <i class="icofont-arrow-left"></i> Back to Dashboard
                                </a>
                                @elseif(Auth::guard('admin')->user()->roles[0]->name == 'student')
                                <a href="{{ route('my-progress') }}" class="btn btn-outline-secondary">
                                    <i class="icofont-arrow-left"></i> Back to Dashboard
                                </a>
                                @elseif(Auth::guard('admin')->user()->roles[0]->name == 'instructor')
                                <a href="{{ route('admin-courses') }}" class="btn btn-outline-secondary">
                                    <i class="icofont-arrow-left"></i> Back to Dashboard
                                </a>
                                @endif
                                @else
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                    <i class="icofont-arrow-left"></i> Back to Dashboard
                                </a>
                                @endif
                            </div>
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
        $(document).ready(function() {
            $(".approve-btn").click(function() {
                let id = $(this).data("id");

                Swal.fire({
                    title: "Approve Enrollment?",
                    text: "This will approve the student's request.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Approve!",
                    confirmButtonColor: "#28a745",
                    cancelButtonColor: "#d33"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('/supervisor/approve') }}/" + id,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire("Approved!", response.message, "success").then(() => location.reload());
                            },
                            error: function() {
                                Swal.fire("Error!", "Failed to approve enrollment.", "error");
                            }
                        });
                    }
                });
            });

            $(".reject-btn").click(function() {
                let id = $(this).data("id");

                Swal.fire({
                    title: "Reject Enrollment?",
                    text: "This will reject the student's request.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, Reject!",
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#28a745"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('/supervisor/reject') }}/" + id,
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                Swal.fire("Rejected!", response.message, "success").then(() => location.reload());
                            },
                            error: function() {
                                Swal.fire("Error!", "Failed to reject enrollment.", "error");
                            }
                        });
                    }
                });
            });
        });
    </script>

</body>

</html>