<!doctype html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')
    {{-- calendar --}}
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        /* body { background-color: #f4f6f9; } */
        .breadcrumbarea { margin-bottom: 20px; }
        .instructor-profile {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .calendar-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        #calendar { max-width: 100%; margin: 0 auto; }
        .filters-container {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }
        .filter-dropdown {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            width: 200px;
        }
        span, p, h2, h1, ul { color: var(--primaryColor) !important; }
        a, h4, h3, li { color: blue !important; }
    </style>
</head>


<body class="body__wrapper">

    @include('include.load')
    @include('include.preload')


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
            @include('include.admin-topbar')
            <div class="dashboard">
                <div class="container-fluid full__width__padding">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-12">
                            @include('include.inst-sidebar')

                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-12">
                            <div class="dashboard__content__wraper">

                                <div class="col-md-8">
                                    <div class="calendar-container">
                                        <h4 style="color:var(--primaryColor)">Group Schedule Calendar</h4>
                    
                                        <!-- Filters -->
                                        <div class="filters-container">
                                            <select id="groupFilter" class="filter-dropdown">
                                                <option value="all">All Groups</option>
                                                @foreach($groups as $group)
                                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                                @endforeach
                                            </select>
                    
                                            <select id="courseFilter" class="filter-dropdown">
                                                <option value="all">All Courses</option>
                                                @foreach($courses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
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
                <!-- dashboardarea__area__end   -->

                <!-- footer__section__start -->
                @include('include.footer')
@include('include.scripts')
                <!-- footer__section__end -->


    </main>


    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var allEvents = [];

            @foreach ($groups as $group)
                allEvents = allEvents.concat({!! json_encode($group->schedules->map(function($schedule) {
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
                        ]
                    ];
                })) !!});
            @endforeach

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: allEvents,

                // Handle date click
                dateClick: function(info) {
                    var selectedDate = info.dateStr;
                    var eventsForDate = allEvents.filter(event => event.extendedProps.date === selectedDate);

                    if (eventsForDate.length > 0) {
                        var eventDetails = eventsForDate.map(event => `
                            <p><strong>Lesson:</strong> ${event.extendedProps.lessonTitle}</p>
                            <p><strong>Group:</strong> ${event.extendedProps.groupName}</p>
                            <p><strong>Start Time:</strong> ${event.extendedProps.start_time}</p>
                            <p><strong>End Time:</strong> ${event.extendedProps.end_time}</p>
                            <p><strong>Meeting ID:</strong> ${event.extendedProps.meetingId ? event.extendedProps.meetingId : 'Not Set'}</p>
                            <hr>
                        `).join('');

                        Swal.fire({
                            title: `Sessions on ${selectedDate}`,
                            html: eventDetails,
                            icon: 'info'
                        });
                    } else {
                        Swal.fire({
                            title: "No Sessions",
                            text: "No scheduled sessions on this day.",
                            icon: "warning"
                        });
                    }
                },

                // Handle event click
                eventClick: function(info) {
                    var ev = info.event;
                    Swal.fire({
                        title: ev.extendedProps.lessonTitle + " (" + ev.extendedProps.groupName + ")",
                        html: `
                            <p><strong>Date:</strong> ${ev.extendedProps.date}</p>
                            <p><strong>Start Time:</strong> ${ev.extendedProps.start_time}</p>
                            <p><strong>End Time:</strong> ${ev.extendedProps.end_time}</p>
                            <p><strong>Meeting ID:</strong> ${ev.extendedProps.meetingId ? ev.extendedProps.meetingId : 'Not Set'}</p>
                        `,
                        icon: 'info'
                    });
                }
            });

            // Filter Function
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

    <!-- JS Dependencies -->
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
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



</body>

</html>
