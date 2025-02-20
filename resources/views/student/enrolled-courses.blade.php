<!DOCTYPE html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')
    <style>
        /* Group Info Styling */
        .group-info-box {
            background: linear-gradient(to right, #007bff, #6610f2);
            color: white;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
        }
        .group-info-box h5 {
            margin-bottom: 5px;
            font-size: 18px;
            font-weight: bold;
        }
        .group-info-box p {
            margin: 3px 0;
            font-size: 14px;
        }
        .group-info-box strong {
            font-weight: 600;
        }
        .course-card {
            margin-top: 0;
        }
    </style>
</head>

<body class="body__wrapper">

    @include('include.preload')

    <main class="main_wrapper overflow-hidden">
        @include('include.nav')

        <div class="dashboardarea sp_bottom_100">
            @include('include.stud-topbar')

            <div class="dashboard">
                <div class="container-fluid full__width__padding">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-12">
                            @include('include.stud-sidebar')
                        </div>

                        <div class="col-xl-9 col-lg-9 col-md-12">
                            <div class="dashboard__content__wraper">
                                <div class="dashboard__section__title">
                                    <h4>My Courses</h4>
                                </div>

                                <div class="row">
                                    @foreach ($courses as $groupStudent)
                                        @php
                                            $group = $groupStudent->group;
                                            $course = $group->course;
                                            $lessonCount = $group->schedules->count();
                                            
                                            // Calculate Total Study Duration
                                            $totalMinutes = $group->schedules->sum(function ($schedule) {
                                                return \Carbon\Carbon::parse($schedule->start_time)->diffInMinutes(\Carbon\Carbon::parse($schedule->end_time));
                                            });
                                            $totalHours = round($totalMinutes / 60, 2);

                                            // Get the instructor
                                            $instructor = \App\Models\User::where('id', $group->instructor_id)->where('role', 'teacher')->first();

                                            // Schedule Details
                                            $startTime = \Carbon\Carbon::parse($group->schedules->first()->start_time)->format('h:i A');
                                            $endTime = \Carbon\Carbon::parse($group->schedules->first()->end_time)->format('h:i A');
                                            $days = $group->schedules->pluck('date')->map(function ($date) {
                                                return \Carbon\Carbon::parse($date)->format('l');
                                            })->unique()->implode(', ');
                                        @endphp

                                        <!-- Group Information (Above Course Card) -->
                                        <div class="col-xl-4 col-lg-6 col-md-6 col-12 course-card">
                                            <div class="group-info-box">
                                                <p><strong>👨‍🏫 Instructor:</strong> {{ $instructor ? $instructor->name : 'Not Assigned' }}</p>
                                                <p><strong>📌 Group Name:</strong> {{ $group->name }}</p>
                                                <p><strong>📅 Total Lessons:</strong> {{ $lessonCount }}</p>
                                                <p><strong>⏳ Estimated Study Time:</strong> ~{{ $totalHours }} Hours</p>
                                                <p><strong>🗓 Schedule:</strong> {{ $days }} ({{ $startTime }} - {{ $endTime }})</p>
                                            </div>
                                            <div class="gridarea__wraper">
                                                <div class="gridarea__img">
                                                    <a href="/course_lessons/{{ $course->id }}">
                                                        <img loading="lazy" src="../img/grid/grid_1.png" alt="grid">
                                                    </a>
                                                    <div class="gridarea__small__button">
                                                        <div class="grid__badge">{{ $course->slug }}</div>
                                                    </div>
                                                </div>
                                                <div class="gridarea__content">
                                                    <div class="gridarea__list">
                                                        <ul>
                                                            <li>
                                                                <i class="icofont-book-alt"></i>
                                                                {{ $lessonCount }} Lesson/s
                                                            </li>
                                                            <li>
                                                                <i class="icofont-clock-time"></i>
                                                                ~{{ $totalHours }} Hours
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="gridarea__heading">
                                                        <h3>
                                                            <a href="/session-details">{{ $course->name }}</a>
                                                        </h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        @include('include.footer')

    </main>

    

    <!-- JS here -->
    <script src="../js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="../js/vendor/jquery-3.6.0.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/isotope.pkgd.min.js"></script>
    <script src="../js/slick.min.js"></script>
    <script src="../js/jquery.meanmenu.min.js"></script>
    <script src="../js/ajax-form.js"></script>
    <script src="../js/wow.min.js"></script>
    <script src="../js/jquery.scrollUp.min.js"></script>
    <script src="../js/imagesloaded.pkgd.min.js"></script>
    <script src="../js/jquery.magnific-popup.min.js"></script>
    <script src="../js/waypoints.min.js"></script>
    <script src="../js/jquery.counterup.min.js"></script>
    <script src="../js/plugins.js"></script>
    <script src="../js/swiper-bundle.min.js"></script>
    <script src="../js/main.js"></script>

</body>

</html>