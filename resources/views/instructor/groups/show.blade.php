<!doctype html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- Custom CSS -->
    <style>
        .student-card {
            background: rgb(35, 0, 233);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: white;
        }

        .student-card h5 {
            margin-bottom: 5px;
            font-size: 16px;
        }

        .student-card .remove-student-btn {
            background: #ff0000;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .student-card .remove-student-btn:hover {
            background: #c82333;
        }

        .edit-date-btn {
            background: #28a745;
            color: white;
            border: none;
            padding: 5px 8px;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-date-btn:hover {
            background: #218838;
        }
    </style>
</head>

<body class="body__wrapper">
    <main class="main_wrapper overflow-hidden">
        @include('include.nav')

        <!-- Breadcrumb Section -->
        <div class="breadcrumbarea breadcrumbarea--2">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8" data-aos="fade-up">
                        <div class="breadcrumb__content__wraper">
                            <div class="breadcrumb__inner text-start">
                                <ul>
                                    <li><a href="/">Home</a></li>
                                    <li><a
                                            href="{{ route('instructor.course_details', $group->course->id) }}">{{ $group->course->name }}</a>
                                    </li>
                                    <li>{{ $group->name }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="course__details__top--2">
                            <div class="course__details__heading">
                                <h3>Group: {{ $group->name }}</h3>
                                <p>{{ $group->description ?? 'No description available' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="shape__icon__2">
                <img loading="lazy" class="shape__icon__img shape__icon__img__1"
                    src="{{ asset('img/herobanner/herobanner__1.png') }}" alt="photo">
                <img loading="lazy" class="shape__icon__img shape__icon__img__2"
                    src="{{ asset('img/herobanner/herobanner__2.png') }}" alt="photo">
                <img loading="lazy" class="shape__icon__img shape__icon__img__3"
                    src="{{ asset('img/herobanner/herobanner__3.png') }}" alt="photo">
                <img loading="lazy" class="shape__icon__img shape__icon__img__4"
                    src="{{ asset('img/herobanner/herobanner__5.png') }}" alt="photo">
            </div>
        </div>

        <!-- Main Content -->
        <div class="blogarea__2 sp_top_80 sp_bottom_100">
            <div class="container-fluid full__width__padding">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-12" data-aos="fade-up">
                        @include('include.sidebar')

                    </div>
                    <!-- Scheduled Lessons -->
                    <div class="col-xl-6 col-lg-6" data-aos="fade-up">
                        <div class="blog__details__content__wraper">
                            <div class="experence__heading">
                                <h5>📅 Scheduled Lessons</h5>
                            </div>
                            <form action="{{ route('instructor.meetings.create_all', $group->id) }}" method="POST">
                                @csrf
                                @if (Auth::guard('admin')->user()->can('meeting-create'))
                                    <button type="submit" class="btn btn-success">
                                        Create Meetings for All Scheduled Lessons
                                    </button>
                                @endif
                            </form>


                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="  headtb text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>Lesson Name</th>
                                            <th>Day</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse ($group->schedules->sortBy('date') as $schedule)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $schedule->lesson->title ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($schedule->date)->format('l') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($schedule->date)->format('Y-m-d') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                                </td>

                                                <td>
                                                    @if (Auth::guard('admin')->user()->can('groupschedule-edit'))
                                                        <button class="edit-date-btn"
                                                            data-schedule-id="{{ $schedule->id }}">
                                                            <i class="icofont-edit"></i> Edit Date
                                                        </button>
                                                    @endif
                                                    <button class="btn btn-warning">
                                                        <i class="icofont-edit"></i> <a
                                                            href="{{ route('session-details', $schedule->id) }}">Report</a>
                                                    </button>

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No lessons scheduled for this
                                                    group.
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar with Students -->
                    <div class="col-xl-3 col-lg-3" data-aos="fade-up">
                        <div class="course__details__sidebar--2">
                            <div class="event__sidebar__wraper">
                                <div class="experence__heading">
                                    <h5>👩‍🎓 Students in this Group</h5>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="  headtb text-white">

                                            <tr>
                                                <th>Name</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($group->students as $student)
                                                <tr>
                                                    <td><a
                                                            href="{{ route('sessionDetailsForStudent', [$student->id, $group->id]) }}">{{ $student->name }}</a>
                                                    </td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2" class="text-center">No students assigned to this
                                                        group.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                @if (Auth::guard('admin')->user()->can('groupstudent-create'))
                                    <button class="btn btn-outline-primary mt-3 add-student-btn">
                                        <i class="icofont-plus"></i> Add Student
                                    </button>
                                @endif


                                <div class="course__summery__button mt-3">
                                    <a class="default__button"
                                        href="{{ route('instructor.groups', $group->course->id) }}">
                                        <i class="icofont-arrow-left"></i> Back to Groups
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('include.footer')
        @include('include.scripts')
    </main>

    <!-- JS -->
    <script src="{{ asset('js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $(document).ready(function() {
            $(".edit-date-btn").click(function() {
                let scheduleId = $(this).data("schedule-id");

                Swal.fire({
                    title: "Edit Lesson Date",
                    html: `<input type="text" id="new_lesson_date" class="swal2-input" placeholder="Select Date">`,
                    didOpen: () => {
                        flatpickr("#new_lesson_date", {
                            dateFormat: "Y-m-d"
                        });
                    },
                    showCancelButton: true,
                    confirmButtonColor: '#ff7918',
                    confirmButtonText: "Save",

                    preConfirm: () => {
                        return {
                            schedule_id: scheduleId,
                            new_date: $("#new_lesson_date").val()
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post("{{ route('lesson.update_date') }}", {
                            _token: "{{ csrf_token() }}",
                            schedule_id: result.value.schedule_id,
                            new_date: result.value.new_date
                        }, function() {
                            Swal.fire({
                                title: "Success",
                                text: "Lesson date updated!",
                                icon: "success",
                                confirmButtonColor: '#ff7918',
                            }).then(
                                () => location.reload());
                        }).fail(() => {
                            Swal.fire({
                                title: "Error",
                                text: "Failed to update!",
                                icon: "error",
                                confirmButtonColor: '#ff7918',
                            });
                        });
                    }
                });
            });
            $('.create-meetings-btn').click(function(e) {
                e.preventDefault();
                let groupId = $(this).data('group-id');
                $.post("{{ route('instructor.meetings.create_all', '') }}/" + groupId, {
                    _token: "{{ csrf_token() }}"
                }, function(response) {
                    Swal.fire({
                            title: "Success",
                            text: response.message,
                            icon: "success",
                            confirmButtonColor: '#ff7918',
                        })
                        .then(() => location.reload());
                }).fail(function(xhr) {
                    Swal.fire("Error", xhr.responseText, "error");
                });
            });

            $(".add-student-btn").click(function() {
                $.ajax({
                    url: "{{ route('instructor.get_students') }}",
                    type: "GET",
                    success: function(response) {
                        let options = '';
                        response.students.forEach(student => {
                            options +=
                                `<option value="${student.id}">${student.name} (${student.email})</option>`;
                        });

                        Swal.fire({
                            title: "Add Student",
                            confirmButtonColor: '#ff7918',
                            html: `
                        <select id="student_id" class="swal2-select" style="width:100%">
                            ${options}
                        </select>
                    `,
                            didOpen: () => {
                                setTimeout(() => {
                                        $("#student_id").select2({
                                            width: "100%",
                                            dropdownParent: $(
                                                ".swal2-popup")
                                        });
                                    },
                                    100
                                ); // Ensure Select2 is applied after the modal opens
                            },
                            showCancelButton: true,
                            confirmButtonText: "Add",
                            preConfirm: () => {
                                return {
                                    student_id: $("#student_id").val()
                                };
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: "{{ route('instructor.add_student') }}",
                                    type: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        group_id: {{ $group->id }},
                                        student_id: result.value.student_id
                                    },
                                    success: function() {
                                        Swal.fire("Success",
                                            "Student added successfully!",
                                            "success").then(
                                            () => location.reload()
                                        );
                                    },
                                    error: function(xhr) {
                                        Swal.fire("Error", xhr.responseText,
                                            "error");
                                    }
                                });
                            }
                        });
                    },
                    error: function() {
                        Swal.fire("Error", "Failed to fetch students!", "error");
                    }
                });
            });
        });
    </script>
</body>

</html>
