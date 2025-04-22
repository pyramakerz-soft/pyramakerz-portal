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
                                <h4>📚 Lesson Resources</h4>

                            </div>
                            <form method="GET" class="mb-4">
                                <div class="row g-2 align-items-end">
                                    <div class="col-md-3">
                                        <label class="form-label">Course</label>
                                        <select name="course_id" class="form-control">
                                            <option value="">All Courses</option>
                                            @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                                {{ $course->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Path</label>
                                        <select name="course_path_id" class="form-control">
                                            <option value="">All Paths</option>
                                            @foreach($coursePaths as $path)
                                            <option value="{{ $path->id }}" {{ request('course_path_id') == $path->id ? 'selected' : '' }}>
                                                {{ $path->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Path of Path</label>
                                        <select name="path_of_path_id" class="form-control">
                                            <option value="">All Path of Paths</option>
                                            @foreach($pathOfPaths as $pop)
                                            <option value="{{ $pop->id }}" {{ request('path_of_path_id') == $pop->id ? 'selected' : '' }}>
                                                {{ $pop->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Lesson</label>
                                        <select name="lesson_id" class="form-control">
                                            <option value="">All Lessons</option>
                                            @foreach($lessons as $lesson)
                                            <option value="{{ $lesson->id }}" {{ request('lesson_id') == $lesson->id ? 'selected' : '' }}>
                                                {{ $lesson->title }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12 mt-2 d-flex gap-2" style="display: flex !important; justify-content: flex-end;">
                                        <button type="submit" class="btn btn-primary" style="background-color: white;">🔍 Filter</button>
                                        <a href="{{ route('admin.lesson-resources.index') }}" class="btn btn-secondary">🔄 Reset</a>
                                    </div>
                                </div>
                            </form>

                            <div class="table-responsive mt-3">
                                <table class="table table-bordered table-striped">
                                    <thead class="headtb text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>Course</th>
                                            <th>Path</th>
                                            <th>Path of Path</th>
                                            <th>Lesson</th>
                                            <th>Type</th>
                                            <th>File/Link</th>
                                            <th>Uploaded At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($resources as $index => $resource)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $resource->lesson->coursePath->course->name }}</td>
                                            <td>{{ $resource->lesson->coursePath->name }}</td>
                                            <td>{{ $resource->lesson->pathOfPath->name ?? 'N/A' }}</td>
                                            <td>{{ $resource->lesson->title ?? 'N/A' }}</td>
                                            <td>{{ ucfirst($resource->resource_type) }}</td>
                                            <td>
                                                @if ($resource->file_path)
                                                <a href="{{ asset($resource->file_path) }}" target="_blank">📎 View File</a>
                                                @elseif ($resource->resource_link)
                                                <a href="{{ $resource->resource_link }}" target="_blank">🔗 Visit Link</a>
                                                @else
                                                N/A
                                                @endif
                                            </td>
                                            <td>{{ $resource->created_at->format('Y-m-d h:i A') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-danger delete-resource-btn"
                                                    data-id="{{ $resource->id }}">
                                                    <i class="icofont-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="12" class="text-center">No resources found.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="mt-3">
                                    {!! $resources->links('pagination::bootstrap-5') !!}
                                </div>
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
        $(document).on("click", ".delete-resource-btn", function() {
            const resourceId = $(this).data("id");

            Swal.fire({
                title: "Are you sure?",
                text: "This will permanently delete the resource.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#aaa",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.lesson-resources.destroy', ':id') }}".replace(':id', resourceId),
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function() {
                            Swal.fire("Deleted!", "The resource has been removed.", "success").then(() => {
                                location.reload();
                            });
                        },
                        error: function() {
                            Swal.fire("Error", "Failed to delete the resource.", "error");
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>