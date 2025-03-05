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
        .select2-results__option {
            padding: 10px;
            font-size: 14px;
            color: #333;
            background: #fff;
            transition: all 0.3s ease-in-out;
        }
        .select2-results__option:hover {
            background: #007bff !important;
            color: #fff !important;
        }
    </style>
</head>

<body class="body__wrapper">
    @include('include.load')
    <main class="main_wrapper overflow-hidden">
        @include('include.dash-nav')
        <div class="dashboardarea sp_bottom_100">
            <div class="container-fluid full__width__padding">
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
                                                @foreach (['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                                    <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>
                                                        {{ $day }}
                                                    </option>
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

                                @php
                                    /* 
                                     * Regroup attendance records by a new key that excludes the day.
                                     * Original key format: "Instructor|Day|Time|Status|Course"
                                     * We remove the Day (index 1) so that records for the same group (Instructor, Time, Status, Course)
                                     * are combined into one table.
                                     */
                                    $combinedAttendanceRecords = $attendanceRecords->groupBy(function($groupKey) {
                                        $parts = explode('|', $groupKey);
                                        unset($parts[1]); // Remove the day
                                        return implode('|', $parts);
                                    });
                                    
                                    // Define all sessions (assumed static for this example)
                                    $allSessions = [
                                        'Session 1',
                                        'Session 2',
                                        'Session 3',
                                        'Session 4',
                                        'Session 5',
                                        'Session 6',
                                        'Session 7',
                                        'Session 8',
                                    ];
                                @endphp

                                <!-- Combined Attendance Table -->
                                @forelse($combinedAttendanceRecords as $group => $attendances)
                                @php
                                    $parts = explode('|', $group);
                                    // Ensure we have 4 parts; if not, pad with empty strings.
                                    while(count($parts) < 4) {
                                        $parts[] = '';
                                    }
                                    [$instructorName, $time, $status, $courseName] = $parts;
                                    $firstAttendance = $attendances->first();
                                    $coursePaths = optional($firstAttendance->course)->coursePaths ?? collect();
                                @endphp

                                    <div class="dashboard__section__title mt-4">
                                        <h5>📌 Instructor: {{ $instructorName }}</h5>
                                        <p>⏰ Time: {{ $time }} | 🔹 Status: {{ $status }}</p>
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
                                                @foreach ($attendances as $attendance)
                                                    @php
                                                        // Convert sessions from JSON to array, if needed
                                                        $sessionData = is_string($attendance->sessions)
                                                            ? json_decode($attendance->sessions, true)
                                                            : (is_array($attendance->sessions) ? $attendance->sessions : []);
                                                    @endphp
                                                    <tr>
                                                        <td>pyra-{{ $attendance->student->id ?? '0' }}</td>
                                                        <td>{{ optional($attendance->student)->name ?? 'N/A' }}</td>
                                                        @foreach ($coursePaths as $coursePath)
                                                            @foreach ($coursePath->paths as $subPath)
                                                                @foreach ($allSessions as $index => $session)
                                                                    @php
                                                                        // Only display attendance if it matches the course path and sub-path
                                                                        $attendanceData =
                                                                            ($attendance->course_path_id == $coursePath->id &&
                                                                             $attendance->path_of_path_id == $subPath->id)
                                                                             ? ($sessionData[$index] ?? null)
                                                                             : null;
                                                                    @endphp
                                                                    <td>{!! $attendanceData === 1 ? '✔' : ($attendanceData === 0 ? '✘' : '—') !!}</td>
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
