<!DOCTYPE html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')

    <style>
      /* Main Layout */
      .zoom-container {
            display: flex;
            flex-direction: row;
            gap: 20px;
            align-items: flex-start;
            justify-content: center;
            padding: 30px;
            max-width: 1200px;
            margin: auto;
        }

        /* Zoom Meeting Frame */
        .zoom-frame {
            flex: 2;
            height: 500px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            background: #1e1e2f;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #zoomContainer {
            width: 100%;
            height: 500px;
            border-radius: 12px;
            overflow: hidden;
            position: relative;
            background: transparent !important;
            z-index: 9999 !important;
        }

        /* Fix Zoom Black Box */
        #zmmtg-root {
            position: absolute !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background-color: transparent !important;
            z-index: 9999 !important;
            display: block !important;
        }

        /* Sidebar Styling */
        .sidebar {
            flex: 1;
            background: #282c3f;
            padding: 20px;
            border-radius: 12px;
            color: white;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Session Details Box */
        .session-details {
            background: #2d3248;
            padding: 15px;
            border-radius: 12px;
            color: #f8d210;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            font-size: 16px;
        }

        /* Student List */
        .student-list {
            list-style: none;
            padding: 0;
            max-height: 250px;
            overflow-y: auto;
            background: #2d3248;
            border-radius: 12px;
            padding: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .present {
            color: #28a745;
            font-weight: bold;
        }

        .absent {
            color: #dc3545;
            font-weight: bold;
        }

        /* Upload Homework */
        .upload-homework {
            background: #f8d210;
            padding: 6px 12px;
            border-radius: 6px;
            color: #333;
            font-weight: bold;
            cursor: pointer;
        }

        /* Hide empty black spaces */
        html, body {
            overflow-x: hidden;
            margin: 0;
            padding: 0;
            background: #1e1e2f;
        }



    </style>
</head>

<body class="body__wrapper">
    @include('include.nav')
    <!-- Lodash (Fix _ is not defined error) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"></script>

<!-- Zoom SDK -->
<script src="https://source.zoom.us/2.16.0/lib/vendor/react.min.js"></script>
<script src="https://source.zoom.us/2.16.0/lib/vendor/react-dom.min.js"></script>
<script src="https://source.zoom.us/2.16.0/lib/vendor/redux.min.js"></script>
<script src="https://source.zoom.us/2.16.0/lib/vendor/redux-thunk.min.js"></script>
<script src="https://source.zoom.us/2.16.0/lib/vendor/jquery.min.js"></script>
<script src="https://source.zoom.us/zoom-meeting-2.16.0.min.js"></script>

    <main class="main_wrapper overflow-hidden">
        @include('include.stud-topbar')

        <div class="zoom-container">
            <!-- Zoom Meeting Frame -->
            <div class="zoom-frame">
                {{-- <div id="zoomContainer" style="width: 100%; height: 500px;"></div> --}}

            </div>

            <!-- Sidebar with Session Details -->
            <div class="sidebar">
                <div>
                    <h5>📝 Session Details</h5>
                    <p><strong>📅 Date:</strong> {{ \Carbon\Carbon::parse($meeting->start_time)->format('M d, Y') }}</p>
                    <p><strong>⏳ Duration:</strong> {{ $meeting->duration }} mins</p>
                    <p><strong>👨‍🎓 Students:</strong> {{ count($students) }}</p>
                </div>

                <div>
                    <h5>🎓 Students</h5>
                    <ul class="student-list">
                        @foreach ($students as $student)
                        @php
                        // Fetch all schedules for the group, sorted by lesson order
                        $allSchedules = \App\Models\GroupSchedule::where('group_id', $meeting->group_id)
                            ->orderBy('lesson_id', 'asc')
                            ->pluck('lesson_id')
                            ->toArray();
                    
                        // Find the session index for the current lesson
                        $sessionIndex = array_search($meeting->lesson->id, $allSchedules);
                    
                        // Fetch attendance record for the student
                        $attendance = \App\Models\Attendance::where('student_id', $student->id)
                            ->where('course_path_id', $meeting->lesson->course_path_id)
                            ->where('path_of_path_id', $meeting->lesson->path_of_path_id)
                            ->first();
                    
                        // Get the `sessions` field
                        $rawSessions = $attendance->sessions ?? '';
                    
                        // Ensure `sessions` is in the correct format
                        if (is_string($rawSessions)) {
                            // Clean any extra characters before decoding
                            $cleanJson = trim(str_replace(["\r", "\n"], '', $rawSessions));
                            $sessions = json_decode($cleanJson, true);
                        } elseif (is_array($rawSessions)) {
                            // Already an array, no need to decode
                            $sessions = $rawSessions;
                        } else {
                            // Default to empty array if data is invalid
                            $sessions = [];
                        }
                    
                        // Ensure `$sessions` is an array
                        $sessions = is_array($sessions) ? $sessions : [];
                    
                        // Determine if the student was present
                        $isPresent = isset($sessions[$sessionIndex]) && $sessions[$sessionIndex] == 1;
                    @endphp
                    

                    

                            <li id="student-{{ $student->id }}">
                                <span>{{ $student->name }}</span>
                                <span class="attendance-status {{ $isPresent ? 'present' : 'absent' }}">
                                    {{ $isPresent ? '✔️ Present' : '❌ Absent' }}
                                </span>
                                @if ($student->id == auth()->id())
                                    <span id="homework-{{ $student->id }}" class="upload-homework" onclick="uploadHomework()">📂 Upload</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Homework Upload Modal -->
        <div class="overlay" id="overlay" onclick="closeModal()"></div>
        <div id="homeworkModal">
            <h4>📂 Upload Your Homework</h4>
            <input type="file" id="homeworkFile">
            <button onclick="submitHomework()">Upload</button>
            <button onclick="closeModal()" style="background: red; margin-left: 10px;">Cancel</button>
        </div>
    </main>

<script>
    document.addEventListener("DOMContentLoaded", function () {
    ZoomMtg.setZoomJSLib("https://source.zoom.us/2.16.0/lib", "/av");
    ZoomMtg.preLoadWasm();
    ZoomMtg.prepareWebSDK();

    let meetingConfig = {
        meetingNumber: "{{ $meeting['id'] }}",
        userName: "{{ auth()->user()->name }}",
        passWord: "{{ $meeting['password'] }}",
        leaveUrl: "{{ route('home') }}",
        role: 0,
        userEmail: "{{ auth()->user()->email }}",
        lang: "en-US",
    };

    fetch("{{ route('zoom.generate_signature', ['meeting_id' => $meeting['id']]) }}")
        .then(response => response.json())
        .then(data => {
            if (!data.signature) {
                console.error("Zoom API Error:", data.error, "Details:", data.details);
                return;
            }

            ZoomMtg.init({
                leaveUrl: "{{ route('home') }}",
                isSupportAV: true,
                disablePreview: false,
                success: function () {
                    document.getElementById("zmmtg-root").style.display = "none"; // Hide extra black space
                    document.getElementById("zoomContainer").style.display = "block"; // Show meeting properly
                    
                    ZoomMtg.join({
                        meetingNumber: "{{ $meeting['id'] }}",
                        userName: "{{ auth()->user()->name }}",
                        signature: data.signature,
                        apiKey: "{{ env('ZOOM_CLIENT_ID') }}",
                        passWord: "{{ $meeting['password'] }}",
                        success: function () {
                            console.log("Joined Zoom Meeting Successfully!");
                        },
                        error: function (err) {
                            console.error("Zoom Join Error:", err);
                        }
                    });
                },
                error: function (err) {
                    console.error("Zoom Init Error:", err);
                }
            });
        })
        .catch(error => console.error("Error fetching signature:", error));
});

</script>

    
    <!-- JavaScript -->
    <script>
        function uploadHomework() {
            document.getElementById('homeworkModal').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('homeworkModal').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        function submitHomework() {
            let file = document.getElementById('homeworkFile').files[0];
            if (!file) {
                alert("📂 Please select a file!");
                return;
            }

            let formData = new FormData();
            formData.append("homework", file);
            formData.append("_token", "{{ csrf_token() }}");

            fetch("{{ route('homework.upload') }}", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(() => {
                alert("✅ Homework uploaded successfully!");
                document.getElementById('homework-' + {{ auth()->id() }}).classList.remove('upload-homework');
                document.getElementById('homework-' + {{ auth()->id() }}).classList.add('submitted-homework');
                document.getElementById('homework-' + {{ auth()->id() }}).innerText = "✅ Submitted";
                closeModal();
            })
            .catch(() => {
                alert("❌ Upload failed! Please try again.");
            });
        }
    // Function to update attendance dynamically
    function updateAttendance() {
    fetch("{{ route('attendance.fetch', ['meeting' => $meeting->id]) }}")
        .then(response => response.text())  // First, get raw text
        .then(text => {
            console.log("Raw server response:", text); // Debugging

            try {
                let data = JSON.parse(text); // Now try parsing JSON
                console.log("Parsed JSON:", data);

                if (!data.students || !Array.isArray(data.students)) {
                    console.error("Unexpected response format:", data);
                    return;
                }

                data.students.forEach(student => {
                    console.log(`Updating student ${student.id}: Present -> ${student.is_present}`);
                    
                    let statusElement = document.querySelector(`#student-${student.id} .attendance-status`);

                    if (statusElement) {
                        statusElement.classList.remove('present', 'absent');
                        statusElement.classList.add(student.is_present ? 'present' : 'absent');
                        statusElement.innerText = student.is_present ? '✔️ Present' : '❌ Absent';
                    }
                });

            } catch (error) {
                console.error("Error parsing JSON:", error, text);
            }
        })
        .catch(error => console.error("Error fetching attendance:", error));
}



    // Poll every 30 seconds
    setInterval(updateAttendance, 50000);
    function submitHomework() {
        let file = document.getElementById('homeworkFile').files[0];
        if (!file) {
            alert("📂 Please select a file!");
            return;
        }

        let formData = new FormData();
        formData.append("homework", file);
        formData.append("_token", "{{ csrf_token() }}");

        fetch("{{ route('homework.upload') }}", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(() => {
            alert("✅ Homework uploaded successfully!");
            
            let homeworkButton = document.getElementById('homework-' + {{ auth()->id() }});
            if (homeworkButton) {
                homeworkButton.classList.remove('upload-homework');
                homeworkButton.classList.add('submitted-homework');
                homeworkButton.innerText = "✅ Submitted";
            }

            closeModal();
        })
        .catch(() => {
            alert("❌ Upload failed! Please try again.");
        });
    }

    </script>
</body>
</html>
