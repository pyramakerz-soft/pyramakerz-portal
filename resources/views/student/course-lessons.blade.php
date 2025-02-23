<!DOCTYPE html>
<html class="no-js is_dark" lang="zxx">
<head>
    @include('include.head')
    <style>
        /* Lesson Cards Styling */
        .lesson-card {
            background: #007bff !important;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
            cursor: pointer;
            color: white;
        }
        .lesson-card:hover {
            background: #0056b3 !important;
        }
        .lesson-card.active {
            background: var(--primaryColor) !important;
        }
        .lesson-card h5 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .lesson-card p {
            font-size: 14px;
            margin: 2px 0;
        }
        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            max-width: 100%;
            background: black;
        }
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
        /* Countdown Timer */
        .countdown-strip {
            background: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .status-start {
            background: var(--primaryColor) !important;
        }
        .status-late {
            background: #ffc107 !important;
            color: black !important;
        }
        .status-very-late {
            background: #dc3545 !important;
        }
    </style>
</head>
<body class="body__wrapper">
    @include('include.nav')
    <div class="tution sp_bottom_100 sp_top_50">
        @include('include.stud-topbar')
        <br><br>
        <div class="container-fluid full__width__padding">
            <div class="row">
                <!-- Sidebar: Lessons List -->
                <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="accordion content__cirriculum__wrap" id="lessonList">
                        @foreach ($lessons as $index => $lesson)
                            @php
                                // Convert lesson date and times to timestamps (milliseconds)
                                $startDateTime = \Carbon\Carbon::parse($lesson['date'] . ' ' . $lesson['start_time'])->timestamp * 1000;
                                $endDateTime = \Carbon\Carbon::parse($lesson['date'] . ' ' . $lesson['end_time'])->timestamp * 1000;
                                // Use the lesson's video_url directly from the lesson table
                                $videoUrl = $lesson['video_url'];
                                // Get meeting URL if meeting exists (if applicable)
                                $meeting = \App\Models\Meeting::where('lesson_id', $lesson['id'])
                                    ->where('group_id', $lesson['group_id'])
                                    ->where('group_schedule_id', $lesson['schedule_id'])
                                    ->where('status', 'live')
                                    ->first();
                            @endphp
                            <div class="lesson-card" id="lesson-card-{{ $index }}" 
                            onclick="selectLesson({{ $index }}, '{{ $lesson['title'] }}', '{{ $videoUrl }}', {{ $startDateTime }}, {{ $endDateTime }}, '{{ $meeting ? $meeting->id : '' }}')">
                                <h5>Lesson #{{ $index + 1 }} - {{ $lesson['title'] }}</h5>
                                <p><strong>📅 Date:</strong> {{ $lesson['date'] }}</p>
                                <p><strong>⏰ Time:</strong> {{ $lesson['start_time'] }} - {{ $lesson['end_time'] }}</p>
                                
                                <!-- Lesson Resources -->
                                @if (($lesson['materials'] ?? collect([]))->isNotEmpty())
                                    <div class="lesson-resources mt-3">
                                        @foreach ($lesson['materials'] as $resource)
                                            @if ((is_null($resource->group_id) || $resource->group_id == $lesson['group_id']) &&
                                                 (is_null($resource->group_schedule_id) || $resource->group_schedule_id == $lesson['schedule_id']))
                                                <div class="resource-item mb-2">
                                                    <a href="{{ asset('storage/' . $resource->file_path) }}" target="_blank">
                                                        {{ $resource->title ?? basename($resource->file_path) }}
                                                    </a>
                                                    <a href="{{ asset('storage/' . $resource->file_path) }}" download class="btn btn-sm btn-outline-primary ml-2">
                                                        Download
                                                    </a>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p>No resources available for this lesson.</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Main Lesson Content -->
                <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="lesson__content__main">
                        <div id="countdown-timer" class="countdown-strip">Loading...</div>
                        <div class="lesson__content__wrap">
                            <h3 id="lesson-title">{{ $lessons[0]['title'] ?? 'Lesson Video' }}</h3>
                            <span><a href="{{ route('student.courses') }}">Back to Courses</a></span>
                        </div>
                        <div id="lesson-video" class="video-container">
                            @php
                                $videoUrl = $lessons[0]['video_url'] ?? null;
                            @endphp
                            @if ($videoUrl)
                                <iframe src="{{ $videoUrl }}" allowfullscreen allow="autoplay"></iframe>
                            @else
                                <p>No video available for this lesson.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('include.footer')

    <!-- JS Scripts -->
    <script>
        let activeLessonIndex = 0;
        let countdownInterval;
        let meetingUrl = '';

        function selectLesson(index, title, videoUrl, startTime, endTime, meetingLink) {
            activeLessonIndex = index;
            meetingUrl = meetingLink;

            // Update lesson title
            document.getElementById('lesson-title').innerText = title;

            // Update video content
            if (videoUrl) {
                document.getElementById('lesson-video').innerHTML = `<iframe src="${videoUrl}" allowfullscreen allow="autoplay"></iframe>`;
            } else {
                document.getElementById('lesson-video').innerHTML = "<p>No video available for this lesson.</p>";
            }

            // Remove active class from all lesson cards and add to the selected one
            document.querySelectorAll('.lesson-card').forEach(card => card.classList.remove('active'));
            document.getElementById(`lesson-card-${index}`).classList.add('active');

            // Clear previous countdown and start a new timer
            clearInterval(countdownInterval);
            updateCountdownTimer(startTime, endTime);
        }

        function updateCountdownTimer(startTime, endTime) {
            let timerElement = document.getElementById('countdown-timer');

            function refreshTimer() {
                let now = new Date().getTime();
                let diff = startTime - now;

                if (diff > 0) {
                    let minutes = Math.floor(diff / 60000);
                    let seconds = Math.floor((diff % 60000) / 1000);
                    timerElement.innerText = `Lesson starts in: ${minutes}m ${seconds}s`;
                } else if (now >= startTime - 300000 && now < startTime) {
                    timerElement.classList.add('status-start');
                    timerElement.innerHTML = `<a href="/meetings/${meetingUrl}" class="btn btn-success">Start Session</a>`;
                } else if (now > startTime && now < endTime) {
                    timerElement.classList.add('status-late');
                    timerElement.innerHTML = `<a href="/meetings/${meetingUrl}" class="btn btn-warning">Join Session Late</a>`;
                } else {
                    timerElement.classList.add('status-very-late');
                    timerElement.innerText = "Session Ended";
                    clearInterval(countdownInterval);
                }
            }

            refreshTimer();
            countdownInterval = setInterval(refreshTimer, 1000);
        }
    </script>
</body>
</html>
