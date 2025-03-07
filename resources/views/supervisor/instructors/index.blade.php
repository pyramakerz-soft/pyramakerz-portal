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
                                <h4>📋 Instructors</h4>
                                <div class="dashboardarea__right">
                                    <!-- Add Instructor Button -->
                                    <div class="dashboardarea__right__button">
                                        <button class="default__button add-instructor-btn">
                                            <i class="icofont-plus"></i> Add Instructor
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="  headtb text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>Instructor Name</th>
                                            <th>Governorate</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Instructor Load</th>
                                            <th>Courses</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($instructors as $index => $instructor)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $instructor->name }}</td>
                                                <td>{{ $instructor->governorate ?? 'N/A' }}</td>
                                                <td>{{ $instructor->phone ?? 'N/A' }}</td>
                                                <td>{{ $instructor->email }}</td>
                                                <td>{{ $instructor->courses->count() }}</td>
                                                <td>{{ $instructor->courses->pluck('name')->join(', ') ?: 'No Courses' }}
                                                </td>

                                                <td>

                                                    <button class="btn btn-sm btn-black comment-btn"
                                                        data-instructor-id="{{ $instructor->id }}">
                                                        <i class="icofont-comment"></i>
                                                    </button>


                                                    <a href="{{ route('admin.evaluations.index', ['instructor_id' => $instructor->id]) }}"
                                                        class="btn btn-sm btn-black">
                                                        <i class="icofont-chart-histogram"></i>
                                                    </a>

                                                </td>

                                            </tr>
                                        @endforeach
                                        @if ($instructors->isEmpty())
                                            <tr>
                                                <td colspan="8" class="text-center">No Instructors Available.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                    <i class="icofont-arrow-left"></i> Back to Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('include.scripts')
    </main>

    <!-- JS -->
    <script src="../js/vendor/jquery-3.6.0.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".comment-btn").click(function() {
                let instructorId = $(this).data("instructor-id");

                $.get("{{ url('/supervisor/instructors/comments') }}/" + instructorId, function(comments) {
                    let commentsHtml = comments.length ? "" : "<p>No comments yet.</p>";

                    comments.forEach(comment => {
                        commentsHtml += `<div class="comment-box">
                        <strong>${comment.admin.name}:</strong> ${comment.comment}
                        <small class="text-muted d-block">${new Date(comment.created_at).toLocaleString()}</small>
                    </div><hr>`;
                    });

                    Swal.fire({
                        title: "Instructor Comments",
                        html: `
                        <div style="max-height: 300px; overflow-y: auto;">
                            ${commentsHtml}
                        </div>
                        <textarea id="new_comment" class="swal2-textarea" placeholder="Write a comment..."></textarea>
                    `,
                        showCancelButton: true,
                        confirmButtonText: "Add Comment",
                        
                        preConfirm: () => {
                            return {
                                instructor_id: instructorId,
                                comment: $("#new_comment").val(),
                            };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.post("{{ route('admin.instructors.comment') }}", {
                                _token: "{{ csrf_token() }}",
                                instructor_id: result.value.instructor_id,
                                comment: result.value.comment
                            }, function() {
                                Swal.fire({
                                        title: "Success",
                                        text: "Comment added!",
                                        icon: "success",
                                        confirmButtonColor: "#ff7918"
                                    })
                                    .then(() => location.reload());
                            }).fail(() => {
                                ({
                                    title: "Error",
                                    text: "Failed to add comment!",
                                    icon: "error",
                                    confirmButtonColor: "#ff7918"
                                });
                            });
                        }
                    });
                }).fail(() => {
                    Swal.fire("Error", "Could not fetch comments!", "error", );
                });
            });

            $(".add-instructor-btn").click(function() {
                Swal.fire({
                    title: "Add New Instructor",
                    html: `
                    <input type="text" id="instructor_name" class="swal2-input" placeholder="Instructor Name">
                    <input type="email" id="instructor_email" class="swal2-input" placeholder="Email">
                    <input type="text" id="instructor_phone" class="swal2-input" placeholder="Phone Number">
                    <input type="text" id="instructor_governorate" class="swal2-input" placeholder="Governorate">
                    <input type="password" id="instructor_password" class="swal2-input" placeholder="Password">
                `,
                    showCancelButton: true,
                    confirmButtonText: "Add Instructor",
                    
                    preConfirm: () => {
                        console.log($("#instructor_phone").val())
                        console.log($("#instructor_governorate").val())
                        return {
                            name: $("#instructor_name").val(),
                            email: $("#instructor_email").val(),
                            phone: $("#instructor_phone").val(),
                            governorate: $("#instructor_governorate").val(),
                            password: $("#instructor_password").val()
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.instructors.store') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                name: result.value.name,
                                email: result.value.email,
                                phone: result.value.phone,
                                governorate: result.value.governorate,
                                password: result.value.password,
                                role: 'instructor'
                            },
                            success: function() {
                                Swal.fire({
                                    title: "Success",
                                    text: "Instructor added successfully!",
                                    icon: "success",
                                    confirmButtonColor: "#ff7918"
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            },
                            error: function(xhr) {
                                let errorMessage = "Failed to add instructor!";
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                Swal.fire({
                                    title: "Error",
                                    text: errorMessage,
                                    icon: "error",
                                    confirmButtonColor: "#ff7918"
                                });

                            }
                        });
                    }
                });
            });

        });
    </script>

</body>

</html>
