<!doctype html>
<html class="no-js is_dark" lang="zxx">
<head>
    @include('include.head')
    <!-- FullCalendar CSS (using version 5) -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet" />
    <!-- SweetAlert2 CSS (optional, if not already included) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body { background-color: #f4f6f9; }
        .breadcrumbarea { margin-bottom: 20px; }
        .instructor-profile {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .instructor-profile h4 { color: #007bff; }
        .calendar-container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }
        /* FullCalendar container styling */
        #calendar {
            max-width: 100%;
            margin: 0 auto;
        }
       span,p,h2,h1,ul{
            color: var(--primaryColor) !important;
        }
        a,h4,h3,li{
            color: blue !important;
        }
    </style>
</head>
<body class="body__wrapper">
    @include('include.nav')
    {{-- @include('include.preload') --}}
    @include('include.dash-head')
    <!-- Breadcrumb -->

    <div class="breadcrumbarea" style="background:var(--primaryColor) !important">
        <div class="container">
            <div class="row">
                <div class="col-xl-8">
                    <div class="breadcrumb__content__wraper">
                        <div class="breadcrumb__inner text-start">
                            <ul>
                                <li><a href="/">Home</a></li>
                                {{-- @foreach ($groups as $group)
    <li>
        <a href="{{ route('instructor.course_details', $group->course->id) }}">
            {{ $group->course->name }} (ID: pyra-{{ $group->course->id }})
        </a>
    </li>
    <li>{{ $group->name }}</li>
@endforeach --}}

                                <li>Instructor Profile</li>
                            </ul>
                        </div>
                    </div>
                    <div class="course__details__heading">
                        <h3>Instructor Profile & Group Schedule</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <main class="container" style="padding: 30px;">
        <div class="row">
            <!-- Instructor Profile Sidebar -->
            <div class="col-md-4">
                <div class="instructor-profile">
    @include('include.admin-sidebar')
<br>
                    <h4 style="color:var(--primaryColor)">My Profile</h4>
                    <p style="color:black !important"><strong>Name:</strong> {{ $instructor->name }}</p>
                    <p style="color:black !important"><strong>Email:</strong> {{ $instructor->email }}</p>
                    <p style="color:black !important"><strong>Phone:</strong> {{ $instructor->phone }}</p>
                    <!-- Add more instructor fields as needed -->
                </div>
            </div>
            <!-- Calendar and Group Schedules -->
            <div class="col-md-8">
                <div class="calendar-container">
                    <h4 style="color:var(--primaryColor)">Group Schedule Calendar</h4>
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </main>

    @include('include.footer')

    <!-- JS Dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>

           




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
                        'end'   => $schedule->date . 'T' . $schedule->end_time,
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
                
                // Handle click on a specific date (show all sessions for that day)
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
    
                // Handle event click (open session details)
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
    
            calendar.render();
        });
    </script>
    



</body>

</html>
