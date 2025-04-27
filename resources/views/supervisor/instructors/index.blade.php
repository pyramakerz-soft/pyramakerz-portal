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
                                    <div class="dashboardarea__right__button" style="display: flex; justify-content: center; align-items: center; gap: 10px;">
                                        <button class="default__button add-instructor-btn">
                                            <i class="icofont-plus"></i> Add Instructor
                                        </button>
                                        <form action="{{ route('admin.instructors.index') }}">
                                            <div class="form-group " style="display: flex; margin-bottom: 0px; gap: 5px; height: 50px;">
                                                <input type="text" name="search" style="width:80%" placeholder="Search by instructor name" class="form-control"
                                                    value="{{ request('search') }}">
                                                <button type="submit" style="float:right;width:20%" class="form-control"><i class="icofont-search-2"></i></button>
                                            </div>
                                        </form>
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
                                                    data-instructor-id="{{ $instructor->id }}"
                                                    title="Add a comment">
                                                    <i class="icofont-comment"></i>
                                                </button>

                                                <a href="{{ route('admin.evaluations.index', ['instructor_id' => $instructor->id]) }}"
                                                    class="btn btn-sm btn-black"
                                                    title="View evaluations">
                                                    <i class="icofont-chart-histogram"></i>
                                                </a>

                                                <button class="btn btn-sm btn-black edit-instructor-btn"
                                                    data-id="{{ $instructor->id }}"
                                                    data-name="{{ $instructor->name }}"
                                                    data-email="{{ $instructor->email }}"
                                                    data-phone="{{ $instructor->phone }}"
                                                    data-governorate="{{ $instructor->governorate }}"
                                                    title="Edit instructor">
                                                    <i class="icofont-edit"></i>
                                                </button>

                                                <a href="{{ route('admin.instructor.delete', ['id' => $instructor->id]) }}"
                                                    class="btn btn-sm btn-black delete-instructor-btn"
                                                    data-url="{{ route('admin.instructor.delete', ['id' => $instructor->id]) }}"
                                                    title="Delete instructor">
                                                    <i class="icofont-delete"></i>
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

    <!-- JS -->
    <script src="../js/vendor/jquery-3.6.0.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/main.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).on("click", ".delete-instructor-btn", function(e) {
            e.preventDefault(); // Prevent the default link behavior

            const url = $(this).data("url");

            Swal.fire({
                title: "Are you sure?",
                text: "This will permanently delete the instructor.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".edit-instructor-btn").click(function() {
                const id = $(this).data("id");
                const name = $(this).data("name");
                const email = $(this).data("email");
                const phone = $(this).data("phone");
                const governorate = $(this).data("governorate");

                Swal.fire({
                    title: "Edit Instructor",
                    html: `
            <input type="text" id="instructor_name" class="swal2-input" placeholder="Instructor Name" value="${name}">
            <input type="email" id="instructor_email" class="swal2-input" placeholder="Email" value="${email}">
            <input type="text" id="instructor_phone" class="swal2-input" placeholder="Phone Number" value="${phone ?? ''}">
            <input type="text" id="instructor_governorate" class="swal2-input" placeholder="Governorate" value="${governorate ?? ''}">
        `,
                    showCancelButton: true,
                    confirmButtonText: "Update Instructor",
                    preConfirm: () => {
                        return {
                            id: id,
                            name: $("#instructor_name").val(),
                            email: $("#instructor_email").val(),
                            phone: $("#instructor_phone").val(),
                            governorate: $("#instructor_governorate").val()
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.instructors.update', ['id' => '__ID__']) }}".replace('__ID__', result.value.id),
                            type: "PUT",
                            data: {
                                _token: "{{ csrf_token() }}",
                                _method: "PUT",
                                name: result.value.name,
                                email: result.value.email,
                                phone: result.value.phone,
                                governorate: result.value.governorate
                            },
                            success: function() {
                                Swal.fire({
                                    title: "Success",
                                    text: "Instructor updated successfully!",
                                    icon: "success",
                                    confirmButtonColor: "#ff7918"
                                }).then(() => location.reload());
                            },
                            error: function(xhr) {
                                let errorMessage = "Failed to update instructor!";
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

            $(".comment-btn").click(function() {
                let instructorId = $(this).data("instructor-id");

                function loadComments() {
                    $.get("{{ url('/supervisor/instructors/comments') }}/" + instructorId, function(comments) {
                        let commentsHtml = comments.length ? "" : "<p style='color:black;'>No comments yet.</p>";

                        comments.forEach(comment => {
                            commentsHtml += `
                    <div class="comment-box" data-comment-id="${comment.id}">
                        <strong>${comment.admin.name}:</strong> 
                        <span class="comment-text">${comment.comment}</span>
                        <small class="text-muted d-block">${new Date(comment.created_at).toLocaleString()}</small>
                        <button class="btn btn-sm btn-warning edit-comment" data-id="${comment.id}">Edit</button>
                        <button class="btn btn-sm btn-danger delete-comment" data-id="${comment.id}">Delete</button>
                    </div><hr>`;
                        });

                        Swal.fire({
                            title: "Instructor Comments",
                            html: `
                    <div id="comment-container" style="max-height: 300px; overflow-y: auto;">
                        ${commentsHtml}
                    </div>
                    <textarea id="new_comment" class="swal2-textarea" placeholder="Write a comment..."></textarea>
                `,
                            showCancelButton: true,
                            confirmButtonText: "Add Comment",
                            didRender: () => {
                                // Edit handler
                                $(".edit-comment").click(function() {
                                    let commentId = $(this).data("id");
                                    let originalText = $(`.comment-box[data-comment-id="${commentId}"] .comment-text`).text();

                                    Swal.fire({
                                        title: "Edit Comment",
                                        input: "textarea",
                                        inputValue: originalText,
                                        showCancelButton: true,
                                        confirmButtonText: "Save Changes"
                                    }).then(result => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url: "{{ route('admin.instructors.updateComment', ['id' => '__ID__']) }}".replace('__ID__', commentId),
                                                type: "PUT",
                                                data: {
                                                    _token: "{{ csrf_token() }}",
                                                    comment: result.value
                                                },
                                                success: () => loadComments(),
                                                error: () => Swal.fire("Error", "Failed to update comment!", "error")
                                            });
                                        }
                                    });
                                });

                                // Delete handler
                                $(".delete-comment").click(function() {
                                    let commentId = $(this).data("id");

                                    Swal.fire({
                                        title: "Are you sure?",
                                        text: "This will permanently delete the comment.",
                                        icon: "warning",
                                        showCancelButton: true,
                                        confirmButtonText: "Yes, delete it!"
                                    }).then(result => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url: "{{ route('admin.instructors.deleteComment', ['id' => '__ID__']) }}".replace('__ID__', commentId),
                                                type: "DELETE",
                                                data: {
                                                    _token: "{{ csrf_token() }}"
                                                },
                                                success: () => loadComments(),
                                                error: () => Swal.fire("Error", "Failed to delete comment!", "error")
                                            });
                                        }
                                    });
                                });
                            },
                            preConfirm: () => {
                                return {
                                    instructor_id: instructorId,
                                    comment: $("#new_comment").val(),
                                };
                            }
                        }).then((result) => {
                            if (result.isConfirmed && result.value.comment.trim() !== "") {
                                $.post("{{ route('admin.instructors.comment') }}", {
                                    _token: "{{ csrf_token() }}",
                                    instructor_id: result.value.instructor_id,
                                    comment: result.value.comment
                                }, function() {
                                    Swal.fire("Success", "Comment added!", "success").then(loadComments);
                                }).fail(() => {
                                    Swal.fire("Error", "Failed to add comment!", "error");
                                });
                            }
                        });
                    }).fail(() => {
                        Swal.fire("Error", "Could not fetch comments!", "error");
                    });
                }

                loadComments();
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