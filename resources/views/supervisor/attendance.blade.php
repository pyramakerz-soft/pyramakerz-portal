<!DOCTYPE html>
<html lang="en">
@include('include.head')
<head>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">
    <style>
        /* Select2 Dropdown Styling */
        .select2-container .select2-selection--single {
            height: 40px !important;
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background: #ffffff;
            color: #333;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #333 !important;
            font-weight: 500;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 50%;
            transform: translateY(-50%);
        }
        .select2-dropdown {
            background: #fff !important;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="body__wrapper">
    @include('include.load')
    <main class="main_wrapper overflow-hidden">
        @include('include.dash-nav')
        <div class="dashboardarea sp_bottom_100">
            <div class="container-fluid full__width__padding">
                <!-- Header -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="dashboardarea__wraper">
                            <div class="dashboardarea__inner admin__dashboard__inner">
                                <div class="dashboardarea__left">
                                    <div class="dashboardarea__left__content">
                                        <h5>Welcome</h5>
                                        <h4>{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="dashboard">
                <div class="container-fluid full__width__padding">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-12">
                            @include('include.sidebar')
                        </div>
                        <div class="col-xl-9">
                            <div class="dashboard__content__wraper">
                                <div class="dashboard__section__title">
                                    <h4>📋 Attendance Records</h4>
                                </div>
                                <form action="{{ route('admin.attendance.index') }}" method="GET" class="mb-4">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name="day" class="form-control select2">
                                                <option value="">All Days</option>
                                                @foreach (['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'] as $day)
                                                    <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="instructor_id" class="form-control select2">
                                                <option value="">All Instructors</option>
                                                @foreach ($instructors as $instructor)
                                                    <option value="{{ $instructor->id }}" {{ request('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                                        {{ $instructor->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select name="course_id" class="form-control select2">
                                                <option value="">All Courses</option>
                                                @foreach ($courses as $course)
                                                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                                        {{ $course->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-black w-100">Filter</button>
                                        </div>
                                    </div>
                                </form>

                                <!-- Combined Attendance Table -->
                                @forelse($attendanceRecords as $groupKey => $attendances)
                                @php
                                $parts = explode('|', $groupKey);
                                $parts = array_pad($parts, 5, ''); // Ensure we have 5 parts: Instructor, Day, Time, Status, Course
                                [$instructorName, $day, $time, $status, $courseName] = $parts;
                                // Get coursePaths from the first record.
                                $firstAttendance = $attendances->first();
                                $coursePaths = optional($firstAttendance->course)->coursePaths ?? collect();
                                // Define the sessions columns.
                                $allSessions = ['Session 1','Session 2','Session 3','Session 4','Session 5','Session 6','Session 7','Session 8'];
                            @endphp

                                    <div class="dashboard__section__title mt-4">
                                        <h5>📌 Instructor: {{ $instructorName }}</h5>
                                        <p>📅 Day: {{ $day }} | ⏰ Time: {{ $time }} | 🔹 Status: {{ $status }}</p>
                                        <p>📖 Course: {{ $courseName }}</p>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead class="headtb text-white">
                                                <tr>
                                                    <th rowspan="2">Student ID</th>
                                                    <th rowspan="2">Student Name</th>
                                                    @foreach ($coursePaths as $coursePath)
                                                        <th colspan="{{ count($coursePath->paths) * count($allSessions) }}"
                                                            class="text-center bg-black text-white">
                                                            {{ $coursePath->name }}
                                                        </th>
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    @foreach ($coursePaths as $coursePath)
                                                        @foreach ($coursePath->paths as $subPath)
                                                            <th colspan="{{ count($allSessions) }}"
                                                                class="text-center bg-secondary text-white">
                                                                {{ $subPath->name }}
                                                            </th>
                                                        @endforeach
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    @foreach ($coursePaths as $coursePath)
                                                        @foreach ($coursePath->paths as $subPath)
                                                            @foreach ($allSessions as $session)
                                                                <th>{{ $session }}</th>
                                                            @endforeach
                                                        @endforeach
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- Group by student id to combine rows for the same student --}}
                                                @foreach ($attendances->groupBy('student.id') as $studentId => $studentRecords)
                                                    @php
                                                        $student = $studentRecords->first()->student;
                                                        // For each sub-path column, filter records for that sub-path and merge session data.
                                                    @endphp
                                                    <tr>
                                                        <td>pyra-{{ $student->id }}</td>
                                                        <td>{{ $student->name }}</td>
                                                        @foreach ($coursePaths as $coursePath)
                                                            @foreach ($coursePath->paths as $subPath)
                                                                @php
                                                                    // Filter the records for this student that match the given course path and sub-path.
                                                                    $recordsForSubPath = $studentRecords->filter(function($rec) use ($coursePath, $subPath) {
                                                                        return $rec->course_path_id == $coursePath->id && $rec->path_of_path_id == $subPath->id;
                                                                    });
                                                                    // Merge session data from those records.
                                                                    $mergedSessions = array_fill(0, count($allSessions), null);
                                                                    foreach ($recordsForSubPath as $rec) {
                                                                        $data = is_string($rec->sessions)
                                                                            ? json_decode($rec->sessions, true)
                                                                            : (is_array($rec->sessions) ? $rec->sessions : []);
                                                                        foreach ($data as $index => $value) {
                                                                            // If a value exists (0 or 1), override previous (or you may decide to merge in another way)
                                                                            if ($value !== null) {
                                                                                $mergedSessions[$index] = $value;
                                                                            }
                                                                        }
                                                                    }
                                                                @endphp
                                                                @foreach ($allSessions as $index => $session)
                                                                    <td>{!! $mergedSessions[$index] === 1 ? '✔' : ($mergedSessions[$index] === 0 ? '✘' : '—') !!}</td>
                                                                @endforeach
                                                            @endforeach
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @empty
                                    <p class="text-center">No attendance records found.</p>
                                @endforelse

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
        </div>
    </main>

    <script src="../js/vendor/jquery-3.6.0.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".select2").select2();
        });
    </script>
</body>
</html>
