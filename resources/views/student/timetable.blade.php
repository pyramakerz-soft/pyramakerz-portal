<!doctype html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


</head>

<body class="body__wrapper">
    @include('include.load')
    {{-- @include('include.preload') --}}

    <main class="main_wrapper overflow-hidden">
        @include('include.nav')

        <div class="dashboardarea sp_bottom_100">
            @include('include.stud-topbar')

            <div class="dashboard">
                <div class="container-fluid full__width__padding">
                    <div class="row">
                        <!-- Student Sidebar -->
                        <div class="col-xl-3 col-lg-3 col-md-12">
                            @include('include.stud-sidebar')
                        </div>

                        <!-- Main Content -->
                        <div class="col-xl-9 col-lg-9 col-md-12">
                            <div class="dashboard__content__wraper">
                                <div class="col-md-12">
                                    <div class="calendar-container">
                                        <h4 style="color:var(--primaryColor)">📅 My Timetable</h4>

                                        <!-- Filters -->
                                        <div class="filters-container">
                                            <select id="groupFilter" class="filter-dropdown">
                                                <option value="all">All Groups</option>
                                                @foreach ($groups as $group)
                                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                                @endforeach
                                            </select>

                                            <select id="courseFilter" class="filter-dropdown">
                                                <option value="all">All Courses</option>
                                                @foreach ($courses as $course)
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
            </div>
        </div>

        @include('include.footer')
        @include('include.scripts')
    </main>

    <!-- JS Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

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
                        <p style="color:black;"><strong style="color:#ff7918">Lesson:</strong> ${event.extendedProps.lessonTitle}</p>
                        <p style="color:black;"><strong style="color:#ff7918">Group:</strong> ${event.extendedProps.groupName}</p>
                        <p style="color:black;"><strong style="color:#ff7918">Start Time:</strong> ${event.extendedProps.start_time}</p>
                        <p style="color:black;"><strong style="color:#ff7918">End Time:</strong> ${event.extendedProps.end_time}</p>
                        <p style="color:black;"><strong style="color:#ff7918">Meeting ID:</strong> ${event.extendedProps.meetingId ? event.extendedProps.meetingId : 'Not Set'}</p>
    
    ${event.extendedProps.meetingId 
        ? `<p><button><a href="/meetings/${event.extendedProps.meetingId}" class="btn btn-danger" style="text-decoration:none;color:white;">Join Session</a></button></p>` 
        : ''
    }
    
    <hr>
`).join('');


                        Swal.fire({
                            title: `Sessions on ${selectedDate}`,
                            html: eventDetails,
                            icon: 'warning',
                            
                        });
                    } else {
                        Swal.fire({
                            title: "No Sessions",
                            text: "No scheduled sessions on this day.",
                            icon: "warning",
                            
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
                        <p style="color:black;"><strong style="color:#ff7918">Start Time:</strong> ${ev.extendedProps.start_time}</p>
                        <p style="color:black;"><strong style="color:#ff7918">End Time:</strong> ${ev.extendedProps.end_time}</p>
                        <p style="color:black;"><strong style="color:#ff7918">Meeting ID:</strong> ${ev.extendedProps.meetingId ? ev.extendedProps.meetingId : 'Not Set'}</p>
                        `,
                        icon: 'warning',
                        
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
