<!doctype html>
<html class="no-js" lang="zxx">
@include('include.head')

<body class="body__wrapper">
    @include('include.load')

    <main class="main_wrapper overflow-hidden">
        @include('include.dash-nav')

        <div class="dashboardarea sp_bottom_100">
            <div class="container-fluid full__width__padding">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-12">
                        @include('include.supervisor-sidebar')
                    </div>

                    <div class="col-xl-9 col-lg-9 col-md-12">
                        <div class="dashboard__content__wraper">
                            <div class="dashboard__section__title">
                                <h4>📋 Students</h4>
                                <div class="dashboardarea__right">
                                    <button class="default__button import-students-btn" data-bs-toggle="modal" data-bs-target="#importStudentsModal">
                                        <i class="icofont-upload"></i> Import Students
                                    </button>
                                    <a href="{{ route('admin.students.download-template') }}" class="default__button btn btn-success">
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
                                    <div class="col-md-4">
                                        <select name="course_id" class="form-control">
                                            <option value="">Filter by Course</option>
                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="group_id" class="form-control">
                                            <option value="">Filter by Group</option>
                                            @foreach ($groups as $group)
                                                <option value="{{ $group->id }}">{{ $group->course->name }} - {{ $group->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name="age_group" class="form-control">
                                            <option value="">Filter by Age Group</option>
                                            <option value="6-10">6 - 10</option>
                                            <option value="11-15">11 - 15</option>
                                            <option value="16-20">16 - 20</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-warning mt-3">Apply Filters</button>
                            </form>

                            <!-- Students Table -->
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered text-center">
                                    <thead class="headtb text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Course</th>
                                            <th>Group</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($students as $index => $student)
                                            @php
    // Fetch course (either from group or direct enrollment)
    $groupStudent = $student->groupStudents->first();
    $courseStudent = $student->courseStudents->first();
    $course = $groupStudent ? $groupStudent->group->course->name : ($courseStudent ? $courseStudent->course->name : 'Not Assigned');

    // Fetch group status
    $group = $groupStudent ? $groupStudent->group->name : 'Not Assigned';
                                            @endphp
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $student->name }}</td>
                                                <td>{{ $student->email }}</td>
                                                <td>{{ $student->phone }}</td>
                                                <td>{{ $course }}</td>
                                                <td>
                                                    @if ($groupStudent)
                                                        <span class="badge bg-success p-2 w-100"
                                                            style="font-size: 16px;">{{ $group }}</span>
                                                    @else
                                                        <span class="badge bg-warning p-2 w-100"
                                                            style="font-size: 16px;">Not Assigned</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm {{ $groupStudent ? 'btn-warning' : 'bg-primary btn-primary' }} assign-group-btn"
                                                        data-student-id="{{ $student->id }}"
                                                        data-student-name="{{ $student->name }}"
                                                        data-current-group="{{ $group }}">
                                                        {{ $groupStudent ? 'Change Group' : 'Assign to Group' }}
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                        @if ($students->isEmpty())
                                            <tr>
                                                <td colspan="7" class="text-center">No Students Available.</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="mt-3">
                                {{ $students->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('include.scripts')
    </main>

    <!-- Assign Group Modal (SweetAlert) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
        //     $(".import-students-btn").click(function() {
        //     Swal.fire({
        //         title: "Import Students",
        //         html: `<input type="file" id="student_file" class="swal2-file">`,
        //         showCancelButton: true,
        //         confirmButtonText: "Upload",
        //         preConfirm: () => {
        //             let file = $("#student_file")[0].files[0];
        //             let formData = new FormData();
        //             formData.append('file', file);
        //             formData.append('_token', "{{ csrf_token() }}");

        //             return fetch("{{ route('admin.students.import') }}", {
        //                 method: "POST",
        //                 body: formData
        //             }).then(response => response.json());
        //         }
        //     }).then(() => {
        //         Swal.fire("Success", "Students imported!", "success").then(() => location.reload());
        //     });
        // });

            $(".assign-group-btn").click(function () {
                let studentId = $(this).data("student-id");
                let studentName = $(this).data("student-name");

                let groups = @json($groups->mapWithKeys(fn($group) => [$group->id => $group->course->name . ' - ' . $group->name]));

                Swal.fire({
                    title: `Assign ${studentName} to a Group`,
                    width: '600px', // ⬅️ Increased width for better layout
                    html: `
                    <div style="text-align:left;">
                        <label for="group-selection" class="mb-2" style="font-size: 16px; font-weight: 600;">Select a Group</label>
                        <select id="group-selection" class="swal2-select form-control" style="max-width: 90%; padding: 10px; font-size: 16px;">
                            <option value="">Select a Group</option>
                            ${Object.entries(groups).map(([id, name]) => `<option value="${id}">${name}</option>`).join('')}
                        </select>
                        <p id="course-info" class="mt-3" style="font-size: 16px;"><strong>Course:</strong> <span>-</span></p>
                    </div>
                `,
                    showCancelButton: true,
                    confirmButtonText: 'Assign',
                    confirmButtonColor: '#28a745',
                    preConfirm: () => {
                        let selectedGroupId = $("#group-selection").val();
                        if (!selectedGroupId) {
                            Swal.showValidationMessage("Please select a group.");
                            return false;
                        }
                        return $.post("{{ route('admin.students.assign-group') }}", {
                            _token: "{{ csrf_token() }}",
                            student_id: studentId,
                            group_id: selectedGroupId
                        }).then(response => {
                            if (!response.success) {
                                throw new Error(response.message);
                            }
                        }).catch(error => {
                            Swal.showValidationMessage(error.message);
                        });
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Updated!', `${studentName} has been assigned to a new group.`, 'success')
                            .then(() => location.reload());
                    }
                });

                // Update course name dynamically
                $("#group-selection").change(function () {
                    let selectedId = $(this).val();
                    $("#course-info span").text(selectedId ? groups[selectedId].split(" - ")[0] : "-");
                });
            });
        });

    </script>

</body>
</html>
