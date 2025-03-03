<!DOCTYPE html>
<html class="no-js " lang="zxx">

<head>
    @include('include.head')

</head>

<body class="body__wrapper">



    @include('include.load')


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
                                    <div class="col-xl-12 aos-init aos-animate" data-aos="fade-up">
                                        <ul class="nav  about__button__wrap dashboard__button__wrap" id="myTab"
                                            role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="single__tab__link " data-bs-toggle="tab"
                                                    data-bs-target="#projects__one" type="button" aria-selected="false"
                                                    role="tab">Finished Courses</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="single__tab__link active" data-bs-toggle="tab"
                                                    data-bs-target="#projects__two" type="button" aria-selected="true"
                                                    role="tab" tabindex="-1">Active Courses</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="single__tab__link" data-bs-toggle="tab"
                                                    data-bs-target="#projects__three" type="button"
                                                    aria-selected="false" role="tab" tabindex="-1">Upcomming
                                                    Courses</button>
                                            </li>



                                        </ul>
                                    </div>


                                    <div class="tab-content tab__content__wrapper aos-init aos-animate"
    id="myTabContent" data-aos="fade-up">

    {{-- Finished Courses --}}
    <div class="tab-pane fade " id="projects__one" role="tabpanel" aria-labelledby="projects__one">
        <div class="row">
            @if($finishedCourses->isNotEmpty())
                @foreach ($finishedCourses as $groupStudent)
                    @php
                        $group = $groupStudent->group;
                        $course = $group->course;
                        $lessonCount = $group->schedules->count();

                        $totalMinutes = $group->schedules->sum(function ($schedule) {
                            return \Carbon\Carbon::parse($schedule->start_time)->diffInMinutes(\Carbon\Carbon::parse($schedule->end_time));
                        });
                        $totalHours = round($totalMinutes / 60, 2);
                    @endphp
                    <div class="col-xl-4 col-lg-6 col-md-6 col-12 course-card">
                        <div class="gridarea__wraper">
                            <div class="gridarea__img">
                                <a href="/course_lessons/{{ $course->id }}">
                                    <img loading="lazy" src="{{ asset('img/grid/grid_1.png') }}" alt="grid">
                                </a>
                                <div class="gridarea__small__button">
                                    <div class="grid__badge">{{ $course->slug }}</div>
                                </div>
                            </div>
                            <div class="gridarea__content">
                                <div class="gridarea__list">
                                    <ul>
                                        <li><i class="icofont-book-alt"></i> {{ $lessonCount }} Lesson/s</li>
                                        <li><i class="icofont-clock-time"></i> ~{{ $totalHours }} Hours</li>
                                    </ul>
                                </div>
                                <div class="gridarea__heading">
                                    <h3>
                                        <a href="/course_lessons/{{ $course->id }}">{{ $course->name }}</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center">No Finished Courses Yet.</p>
            @endif
        </div>
    </div>

    {{-- Active Courses --}}
    <div class="tab-pane fade active show" id="projects__two" role="tabpanel" aria-labelledby="projects__two">
        <div class="row">
            {{-- Courses Assigned to a Group --}}
            @if ($groupCourses->isNotEmpty())
                @foreach ($groupCourses as $groupStudent)
                    @php
                        $group = $groupStudent->group;
                        $course = $group->course;
                        $lessonCount = $group->schedules->count();

                        $totalMinutes = $group->schedules->sum(function ($schedule) {
                            return \Carbon\Carbon::parse($schedule->start_time)->diffInMinutes(\Carbon\Carbon::parse($schedule->end_time));
                        });
                        $totalHours = round($totalMinutes / 60, 2);
                    @endphp
                    <div class="col-xl-4 col-lg-6 col-md-6 col-12 course-card">
                        <div class="gridarea__wraper">
                            <div class="gridarea__img">
                                <a href="/course_lessons/{{ $course->id }}">
                                    <img loading="lazy" src="{{ asset('img/grid/grid_1.png') }}" alt="grid">
                                </a>
                                <div class="gridarea__small__button">
                                    <div class="grid__badge">{{ $course->slug }}</div>
                                </div>
                            </div>
                            <div class="gridarea__content">
                                <div class="gridarea__list">
                                    <ul>
                                        <li><i class="icofont-book-alt"></i> {{ $lessonCount }} Lesson/s</li>
                                        <li><i class="icofont-clock-time"></i> ~{{ $totalHours }} Hours</li>
                                    </ul>
                                </div>
                                <div class="gridarea__heading">
                                    <h3>
                                        <a href="/course_lessons/{{ $course->id }}">{{ $course->name }}</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            {{-- Enrolled Courses (Without Group) --}}
            @if ($enrolledCourses->isNotEmpty())
                @foreach ($enrolledCourses as $courseStudent)
                    @php
                        $course = $courseStudent->course;
                        $instructor = $course->instructor;
                    @endphp
                    <div class="col-xl-4 col-lg-6 col-md-6 col-12 course-card">
                        <div class="gridarea__wraper">
                            <div class="gridarea__img">
                                <img loading="lazy" src="{{ asset('img/grid/grid_1.png') }}" alt="grid">
                                <div class="gridarea__small__button">
                                    <div class="grid__badge">{{ $course->slug }}</div>
                                </div>
                            </div>
                            <div class="gridarea__content">
                                <div class="gridarea__list">
                                    <ul>
                                        <li><i class="icofont-book-alt"></i> No Lessons Yet</li>
                                        <li><i class="icofont-clock-time"></i> - </li>
                                    </ul>
                                </div>
                                <div class="gridarea__heading">
                                    <h3>
                                        <a href="javascript:void(0);" class="disabled-link" style="pointer-events: none; color: gray;">
                                            {{ $course->name }}
                                        </a>
                                    </h3>
                                </div>
                                <div class="dashboard__single__counter">
                                    <p><strong>❌ Not Assigned to a Group Yet</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif

            {{-- Show "No Courses Available" only if both lists are empty --}}
            @if ($groupCourses->isEmpty() && $enrolledCourses->isEmpty())
                <p class="text-center">No Active Courses Available.</p>
            @endif
        </div>
    </div>

    {{-- Upcoming Courses --}}
    <div class="tab-pane fade" id="projects__three" role="tabpanel" aria-labelledby="projects__three">
        <div class="row">
            @if ($upcomingCourses->isNotEmpty())
                @foreach ($upcomingCourses as $groupStudent)
                    @php
                        $group = $groupStudent->group;
                        $course = $group->course;
                    @endphp
                    <div class="col-xl-4 col-lg-6 col-md-6 col-12 course-card">
                        <div class="gridarea__wraper">
                            <div class="gridarea__img">
                                <a href="/course_lessons/{{ $course->id }}">
                                    <img loading="lazy" src="{{ asset('img/grid/grid_1.png') }}" alt="grid">
                                </a>
                                <div class="gridarea__small__button">
                                    <div class="grid__badge">{{ $course->slug }}</div>
                                </div>
                            </div>
                            <div class="gridarea__content">
                                <div class="gridarea__heading">
                                    <h3>
                                        <a href="/course_lessons/{{ $course->id }}">{{ $course->name }}</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-center">No Upcoming Courses Yet.</p>
            @endif
        </div>
    </div>

</div>






                                </div>




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
