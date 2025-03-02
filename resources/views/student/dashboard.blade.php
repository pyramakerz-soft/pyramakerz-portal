<!doctype html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>


<body class="body__wrapper">

    @include('include.load')



    <main class="main_wrapper overflow-hidden">
        @include('include.nav')


        <!-- theme fixed shadow -->
        <div>
            <div class="theme__shadow__circle"></div>
            <div class="theme__shadow__circle shadow__right"></div>
        </div>
        <!-- theme fixed shadow -->
        <!-- breadcrumbarea__section__start -->



        <!-- dashboardarea__area__start  -->
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
                                    <h4>Summary</h4>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                        <div class="dashboard__single__counter">
                                            <div class="counterarea__text__wraper">
                                                <div class="counter__img">
                                                    <img loading="lazy" src="{{ asset('img/counter/counter__1.png') }}"
                                                        alt="counter">
                                                </div>
                                                <div class="counter__content__wraper">
                                                    <div class="counter__number">
                                                        <span class="counter">{{ $courses }}</span>

                                                    </div>
                                                    <p>Total Points</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                        <div class="dashboard__single__counter">
                                            <div class="counterarea__text__wraper">
                                                <div class="counter__img">
                                                    <img loading="lazy" src="{{ asset('img/counter/counter__2.png') }}"
                                                        alt="counter">
                                                </div>
                                                <div class="counter__content__wraper">
                                                    <div class="counter__number">
                                                        <span class="counter">08</span>

                                                    </div>
                                                    <p>Complete Courses</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                        <div class="dashboard__single__counter">
                                            <div class="counterarea__text__wraper">
                                                <div class="counter__img">
                                                    <img loading="lazy" src="{{ asset('img/counter/counter__3.png') }}"
                                                        alt="counter">
                                                </div>
                                                <div class="counter__content__wraper">
                                                    <div class="counter__number">
                                                        <span class="counter">12</span>

                                                    </div>
                                                    <p>Earned Hours</p>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12">
                                    <div class="dashboard__content__wraper">
                                        <div class="col-md-12">
                                            <div class="calendar-container">
                                                <h4 style="color:var(--primaryColor)">📅 My Timetable</h4>

                                                <!-- Filters -->
                                                <div class="filters-container" style="display: none;">
                                                    <select id="groupFilter" class="filter-dropdown">
                                                        <option value="all">All Groups</option>
                                                        @foreach ($groups as $group)
                                                            <option value="{{ $group->id }}">{{ $group->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                    <select id="courseFilter" class="filter-dropdown">
                                                        <option value="all">All Courses</option>
                                                        @foreach ($courses as $course)
                                                            <option value="{{ $course->id }}">{{ $course->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div id="calendar"></div>
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
        <!-- dashboardarea__area__end   -->

        <!-- footer__section__start -->
        @include('include.footer')
        @include('include.scripts')
        <!-- footer__section__end -->


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
    {{-- <script src="../js/main.js"></script> --}}


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var allEvents = [];

            @foreach ($groups as $group)
                allEvents = allEvents.concat({!! json_encode(
                    $group->schedules->map(function ($schedule) {
                        return [
                            'id' => $schedule->id,
                            'title' => $schedule->lesson->title,
                            'start' => $schedule->date . 'T' . $schedule->start_time,
                            'end' => $schedule->date . 'T' . $schedule->end_time,
                            'groupId' => $schedule->group->id,
                            'courseId' => $schedule->group->course->id,
                            'extendedProps' => [
                                'groupName' => $schedule->group->name,
                                'lessonTitle' => $schedule->lesson->title,
                                'meetingId' => $schedule->meeting_id,
                                'date' => $schedule->date,
                                'start_time' => $schedule->start_time,
                                'end_time' => $schedule->end_time,
                            ],
                        ];
                    }),
                ) !!});
            @endforeach

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: allEvents,

                dateClick: function(info) {
                    var selectedDate = info.dateStr;
                    var eventsForDate = allEvents.filter(event => event.extendedProps.date ===
                        selectedDate);

                    if (eventsForDate.length > 0) {
                        var eventDetails = eventsForDate.map(event => `
                        <p style="color:black"><strong style="color:#ff7918">Lesson:</strong> ${event.extendedProps.lessonTitle}</p>
                        <p style="color:black"><strong style="color:#ff7918">Group:</strong> ${event.extendedProps.groupName}</p>
                        <p style="color:black"><strong style="color:#ff7918">Start Time:</strong> ${event.extendedProps.start_time}</p>
                        <p style="color:black"><strong style="color:#ff7918">End Time:</strong> ${event.extendedProps.end_time}</p>
                        <p style="color:black"><strong style="color:#ff7918">Meeting ID:</strong> ${event.extendedProps.meetingId ? event.extendedProps.meetingId : 'Not Set'}</p>
    
    ${event.extendedProps.meetingId 
        ? `<p><button ><a href="/meetings/${event.extendedProps.meetingId}" class="btn default_button" style="background-color:#ff7918; text-decoration:none;color:white;">Join Session</a></button></p>` 
        : ''
    }
    
    <hr>
`).join('');


                        Swal.fire({
                            title: `Sessions on ${selectedDate}`,
                            html: eventDetails,
                            icon: 'warning'
                        });
                    } else {
                        Swal.fire({
                            title: "No Sessions",
                            text: "No scheduled sessions on this day.",
                            icon: "warning",
                            confirmButtonColor: '#ff7918'
                        });
                    }
                },

                eventClick: function(info) {
                    var ev = info.event;
                    Swal.fire({
                        title: ev.extendedProps.lessonTitle + " (" + ev.extendedProps
                            .groupName + ")",
                        html: `
                            <p style="color:black;"><strong style="color:#ff7918">Date:</strong> ${ev.extendedProps.date}</p>
                            <p style="color:black"><strong style="color:#ff7918">Start Time:</strong> ${ev.extendedProps.start_time}</p>
                            <p style="color:black"><strong style="color:#ff7918">End Time:</strong> ${ev.extendedProps.end_time}</p>
                            <p style="color:black"><strong style="color:#ff7918">Meeting ID:</strong> ${ev.extendedProps.meetingId ? ev.extendedProps.meetingId : 'Not Set'}</p>
                        `,
                        icon: 'warning',
                        confirmButtonColor: '#ff7918'
                    });
                }
            });

            function filterEvents() {
                var selectedGroup = document.getElementById("groupFilter").value;
                var selectedCourse = document.getElementById("courseFilter").value;

                var filteredEvents = allEvents.filter(event =>
                    (selectedGroup === "all" || event.groupId == selectedGroup) &&
                    (selectedCourse === "all" || event.courseId == selectedCourse)
                );

                calendar.removeAllEvents();
                calendar.addEventSource(filteredEvents);
            }

            document.getElementById("groupFilter").addEventListener("change", filterEvents);
            document.getElementById("courseFilter").addEventListener("change", filterEvents);

            calendar.render();
        });
    </script>

</body>

</html>
