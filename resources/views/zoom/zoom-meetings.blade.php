<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    @include('include.head')
    <title>Zoom Meetings | Alpha Sessions</title>

    <!-- FullCalendar CSS (Optional if needed) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


</head>

<body class="body__wrapper">
    @include('include.load')
    @include('include.dash-nav')
    @include('include.admin-topbar')

    <!-- Breadcrumb -->


    <!-- Content Layout -->
    {{-- <div class="content-wrapper"> --}}
    <!-- Sidebar -->

    <div class="dashboard">
        <div class="container-fluid full__width__padding">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-12">
                    @include('include.admin-sidebar')
                </div>

                <div class="col-xl-9 col-lg-9 col-md-12">
                    <div class="dashboard__content__wraper">
                        <div class="dashboard__section__title">
                            <h2>📅 My Zoom Meetings</h2>
                        </div>

                        <div class="row">
                            @if ($meetings->isEmpty())
                                <div class="col-12">
                                    <div class="alert alert-warning">No Zoom meetings scheduled.</div>
                                </div>
                            @else
                                @foreach ($meetings as $meeting)
                                    @php
                                        $meetingStartTime = \Carbon\Carbon::parse($meeting->start_time);
                                        $currentDateTime = \Carbon\Carbon::now();
                                        $isPastMeeting = $meetingStartTime->isPast();
                                    @endphp

                                    <div class="col-lg-4 col-md-6">
                                        <div class="gridarea__wraper  {{ $isPastMeeting ? 'past-meeting' : '' }}">
                                            <!-- Course Image -->
                                            <img src="{{ asset('img/course.jpg') }}" class="meeting-img"
                                                alt="Course Image">

                                            <div class="meeting-body">
                                                <h4 class="meeting-title">{{ $meeting->topic }}</h4>
                                                <p class="meeting-info">
                                                    <strong>📅 Start Time:</strong>
                                                    {{ $meetingStartTime->format('M d, Y h:i A') }} <br>
                                                    <strong>⏳ Duration:</strong> {{ $meeting->duration }} minutes <br>
                                                    <strong>👨‍🏫 Group:</strong> {{ $meeting->group->name ?? 'N/A' }}
                                                    <br>
                                                    <strong>📖 Lesson:</strong> {{ $meeting->lesson->title ?? 'N/A' }}
                                                </p>

                                                @if (!$isPastMeeting)
                                                    <a href="{{ route('instructor.meeting', $meeting->id) }}"
                                                        target="_blank" class="default__button btn ">🔗 Join Zoom
                                                        Meeting</a>
                                                @else
                                                    <p class="text-muted"><strong>❌ Meeting Expired</strong></p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

            </div>


            @include('include.scripts')

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
