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
                    <div class="col-xl-3 col-lg-3 col-md-12">
                        @include('include.sidebar')
                    </div>

                    <div class="col-xl-9 col-lg-9 col-md-12">
                        <div class="dashboard__content__wraper">
                            <div class="dashboard__section__title">
                                <h4>📋 Students</h4>
                                <div class="dashboardarea__right">
                                    <button class="default__button add-student-btn">
                                        <i class="icofont-plus"></i> Add Student
                                    </button>
                                    <button class="default__button btn" data-bs-toggle="modal" data-bs-target="#importStudentsModal">
                                        <i class="icofont-upload"></i> Import Students
                                    </button>
                                    <a href="{{ route('admin.students.download-template') }}" class="default__button btn ">
                                        <i class="icofont-download"></i> Download Excel Template
                                    </a>
                                </div>
                            </div>
                            <!-- Import Modal -->
                            <div class="modal fade" id="importStudentsModal" tabindex="-1" aria-labelledby="importStudentsModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="importStudentsModalLabel">Import Students</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-body">
                                                <input type="file" name="students_file" class="form-control" required>
                                                <p class="mt-2"><strong>Note:</strong> Upload an Excel file (.xlsx, .csv)</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Upload</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Filters -->
                            <form method="GET" action="{{ route('admin.students.index') }}" class="mb-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <input type="text" name="search" class="form-control" placeholder="Search by Name, Email, or Code" value="{{ request('search') }}">
                                    </div>

                                    <div class="col-md-2">
                                        <select name="course_id" class="form-control">
                                            <option value="">Filter by Course</option>
                                            @foreach ($courses as $course)
                                            <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                                {{ $course->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <select name="group_id" class="form-control">
                                            <option value="">Filter by Group</option>
                                            @foreach ($groups as $group)
                                            <option value="{{ $group->id }}" {{ request('group_id') == $group->id ? 'selected' : '' }}>
                                                {{ $group->course->name }} - {{ $group->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <select name="age_group" class="form-control">
                                            <option value="">Filter by Age Group</option>
                                            <option value="6-10" {{ request('age_group') == '6-10' ? 'selected' : '' }}>6 - 10</option>
                                            <option value="11-15" {{ request('age_group') == '11-15' ? 'selected' : '' }}>11 - 15</option>
                                            <option value="16-20" {{ request('age_group') == '16-20' ? 'selected' : '' }}>16 - 20</option>
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-warning default__small__button mt-2 w-100">Apply Filters</button>
                                    </div>
                                </div>
                            </form>


                            <!-- Students Table -->
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered text-center">
                                    <thead class="headtb text-white">
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Courses</th>
                                            <th>Groups</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $index => $student)
                                        <tr>
                                            <td>{{ $student->code }}</td>
                                            <td>{{ $student->name }}</td>
                                            <td>{{ $student->email }}</td>
                                            <td>{{ $student->phone }}</td>
                                            <td>
                                                @php
                                                // Map and keep full course models first
                                                $coursesFromGroups = $student->groupStudents->map(function($groupStudent) {
                                                return $groupStudent->group?->course;
                                                })->filter()->unique('id')->values();

                                                $coursesFromDirectEnroll = $student->courseStudents->map(function($courseStudent) {
                                                return $courseStudent->course;
                                                })->filter()->unique('id')->values();

                                                $allCourses = $coursesFromGroups->merge($coursesFromDirectEnroll)->unique('id')->values();
                                                @endphp

                                                @if ($allCourses->isNotEmpty())
                                                @foreach ($allCourses as $course)
                                                <span class="badge bg-info p-2 mb-1">{{ $course->name }}</span><br>
                                                @endforeach
                                                @else
                                                <span class="badge bg-warning p-2">Not Assigned</span>
                                                @endif
                                            </td>

                                            <td>
                                                @php
                                                $groups = $student->groupStudents->map(function($groupStudent) {
                                                return $groupStudent->group;
                                                })->filter()->unique('id')->values();
                                                @endphp

                                                @if ($groups->isNotEmpty())
                                                @foreach ($groups as $group)
                                                <span class="badge bg-success p-2 mb-1">{{ $group->name }}</span><br>
                                                @endforeach
                                                @else
                                                <span class="badge bg-warning p-2">Not Assigned</span>
                                                @endif
                                            </td>

                                        </tr>
                                        @endforeach

                                        @if ($students->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center">No Students Available.</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>

                            </div>

                            <!-- Pagination -->
                            <div class="mt-3">
                                {!! $students->links('pagination::bootstrap-5') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('include.scripts')
        @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error ') }}",
            });
        </script>
        @endif
        @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success ') }}",
            });
        </script>
        @endif
    </main>

    <!-- Assign Group Modal (SweetAlert) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $(".add-student-btn").click(function() {
                Swal.fire({
                    title: "Add New Student",
                    html: `
            <input type="text" id="name" class="swal2-input" placeholder="Student Name">
            <input type="email" id="email" class="swal2-input" placeholder="Email" autocomplete="off">
            <input type="text" id="phone" class="swal2-input" placeholder="Phone Number">
            <input type="text" id="parent_phone" class="swal2-input" placeholder="Parent Phone Number">
            <input type="text" id="country" class="swal2-input" placeholder="country">
            <input type="text" id="city" class="swal2-input" placeholder="City">
            <input type="text" id="school" class="swal2-input" placeholder="School">
            <select id="gender" class="swal2-input">
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
           
            <input type="date" style="width: 299px; margin: 0;" id="birthday" class="swal2-input" placeholder="Enter Birthday">
            <input type="text" id="year" class="swal2-input" placeholder="Year">
            <input type="password" id="password" class="swal2-input" placeholder="Password">
        `,
                    showCancelButton: true,
                    confirmButtonText: "Add Student",
                    preConfirm: () => {
                        return {
                            name: $("#name").val(),
                            email: $("#email").val(),
                            phone: $("#phone").val(),
                            parent_phone: $("#parent_phone").val(),
                            country: $("#country").val(),
                            city: $("#city").val(),
                            school: $("#school").val(),
                            gender: $("#gender").val(),
                            birthday: $("#birthday").val(),
                            year: $("#year").val(),
                            password: $("#password").val()
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('admin.students.store') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                name: result.value.name,
                                email: result.value.email,
                                phone: result.value.phone,
                                parent_phone: result.value.parent_phone,
                                country: result.value.country,
                                city: result.value.city,
                                school: result.value.school,
                                gender: result.value.gender,
                                birthday: result.value.birthday,
                                year: result.value.year,
                                password: result.value.password,
                            },
                            success: function() {
                                Swal.fire({
                                    title: "Success",
                                    text: "Student added successfully!",
                                    icon: "success",
                                    confirmButtonColor: "#ff7918"
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            },
                            error: function(xhr) {
                                let errorMessage = "Failed to add student!";
                                if (xhr.responseJSON && xhr.responseJSON.errors) {
                                    const errors = Object.values(xhr.responseJSON.errors).flat().join("\n");
                                    errorMessage = errors;
                                } else if (xhr.responseJSON && xhr.responseJSON.message) {
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