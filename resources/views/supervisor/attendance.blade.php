<!DOCTYPE html>
<html lang="en">
@include('include.head')

<body>
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
                    <div class="col-xl-12">
                        <div class="dashboard__content__wraper">
                            <div class="dashboard__section__title">
                                <h4>📋 Attendance Records</h4>
                            </div>

                            <form action="{{ route('admin.attendance.index') }}" method="GET" class="mb-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="day" class="form-control select2">
                                            <option value="">All Days</option>
                                            @foreach(['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'] as $day)
                                                <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>{{ $day }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <select name="instructor_id" class="form-control select2">
                                            <option value="">All Instructors</option>
                                            @foreach($instructors as $instructor)
                                                <option value="{{ $instructor->id }}" {{ request('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                                    {{ $instructor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <select name="course_id" class="form-control select2">
                                            <option value="">All Courses</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                                    {{ $course->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-3">
                                        <button type="submit" class="btn btn-primary w-100">Filter</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Grouped Attendance Table -->
                            @forelse($attendanceRecords as $group => $attendances)
                                @php
                                    list($instructorName, $day, $time, $status, $courseName) = explode('|', $group);
                                    $firstAttendance = $attendances->first(); 
                                    $coursePaths = optional($firstAttendance->course)->coursePaths ?? collect();
                                    $allSessions = ['Session 1', 'Session 2', 'Session 3', 'Session 4'];
                                @endphp

                                <div class="dashboard__section__title mt-4">
                                    <h5>📌 Instructor: {{ $instructorName }}</h5>
                                    <p>📅 Day: {{ $day }} | ⏰ Time: {{ $time }} | 🔹 Status: {{ $status }}</p>
                                    <p>📖 Course: {{ $courseName }}</p>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th rowspan="2">Student ID</th>
                                                <th rowspan="2">Student Name</th>
                                                @foreach ($coursePaths as $coursePath)
                                                    <th colspan="{{ count($coursePath->paths) * count($allSessions) }}" class="text-center bg-info text-white">
                                                        {{ $coursePath->name }}
                                                    </th>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                @foreach ($coursePaths as $coursePath)
                                                    @foreach ($coursePath->paths as $subPath)
                                                        <th colspan="{{ count($allSessions) }}" class="text-center bg-secondary text-white">
                                                            {{ $subPath->name }}
                                                        </th>
                                                    @endforeach
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th></th><th></th>
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
                                            @foreach($attendances as $attendance)
                                                @php
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
                                                                    // Only show attendance if it matches the correct course path and path of path
                                                                    $attendanceData = ($attendance->course_path_id == $coursePath->id && $attendance->path_of_path_id == $subPath->id) 
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
    $(document).ready(function () {
        $(".select2").select2();
    });
</script>

</body>
</html>
