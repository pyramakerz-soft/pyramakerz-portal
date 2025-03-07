<!DOCTYPE html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')
    <style>
        /* Main Container */
        .zoom-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            align-items: stretch;
            padding: 30px;
        }

        /* Zoom Meeting Frame */
        .zoom-frame {
            flex: 2;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            background: #1e1e2f;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        /* Ensure the embedded Zoom element expands fully */
        #meetingSDKElement {
            width: 100%;
            flex: 1;
        }

        /* Sidebar */
        .sidebar {
            flex: 1;
            min-width: 300px;
            background: #282c3f;
            padding: 20px;
            border-radius: 12px;
            color: white;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Session Details and Student List */
        .sidebar h5 {
            font-size: 20px;
            margin-bottom: 12px;
            color: #f8d210;
        }

        .sidebar p {
            font-size: 16px;
            margin: 6px 0;
            opacity: 0.9;
        }

        .student-list {
            list-style: none;
            padding: 0;
            max-height: 200px;
            overflow-y: auto;
        }

        .student-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            margin-bottom: 5px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .student-list li:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .present {
            color: #28a745;
            font-weight: bold;
        }

        .absent {
            color: #dc3545;
            font-weight: bold;
        }

        /* Homework Modal & Overlay */
        #homeworkModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            text-align: center;
            z-index: 9999;
        }

        #homeworkModal input {
            width: 100%;
            margin: 10px 0;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        /* #homeworkModal button {
            background: #007bff;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }
        #homeworkModal button:hover {
            background: #0056b3;
        } */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9998;
        }

        /* Zoom SDK injected elements */
        #zmmtg-root {
            display: block !important;
            width: 100%;
            background-color: transparent !important;
        }

        body {
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body class="body__wrapper">
    @include('include.nav')
    <!-- Dependencies for Component View via CDN -->
    <script src="https://source.zoom.us/3.6.0/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/3.6.0/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/3.6.0/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/3.6.0/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/3.6.0/lib/vendor/lodash.min.js"></script>
    <!-- CDN for Component View -->
    <script src="https://source.zoom.us/zoom-meeting-embedded-3.6.0.min.js"></script>

    <main class="main_wrapper overflow-hidden">
        @include('include.stud-topbar')
        <div class="zoom-container">
            <!-- Zoom Meeting Frame (Component View) -->
            <div class="zoom-frame">
                <div id="meetingSDKElement"></div>
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
                                $allSchedules = \App\Models\GroupSchedule::where('group_id', $meeting->group_id)
                                    ->orderBy('lesson_id', 'asc')
                                    ->pluck('lesson_id')
                                    ->toArray();
                                $sessionIndex = array_search($meeting->lesson->id, $allSchedules);
                                $attendance = \App\Models\Attendance::where('student_id', $student->id)
                                    ->where('course_path_id', $meeting->lesson->course_path_id)
                                    ->where('path_of_path_id', $meeting->lesson->path_of_path_id)
                                    ->first();
                                $rawSessions = $attendance->sessions ?? '';
                                if (is_string($rawSessions)) {
                                    $cleanJson = trim(str_replace(["\r", "\n"], '', $rawSessions));
                                    $sessions = json_decode($cleanJson, true);
                                } elseif (is_array($rawSessions)) {
                                    $sessions = $rawSessions;
                                } else {
                                    $sessions = [];
                                }
                                $sessions = is_array($sessions) ? $sessions : [];
                                $isPresent = isset($sessions[$sessionIndex]) && $sessions[$sessionIndex] == 1;
                            @endphp
                            <li id="student-{{ $student->id }}">
                                <span>{{ $student->name }}</span>
                                <span class="attendance-status {{ $isPresent ? 'present' : 'absent' }}">
                                    {{ $isPresent ? '✔️ Present' : '❌ Absent' }}
                                </span>
                                @if ($student->id == auth()->id())
                                    <span id="homework-{{ $student->id }}" class="upload-homework"
                                        onclick="uploadHomework()">📂 Upload</span>
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

    <!-- Zoom Meeting SDK Component View Script -->
    <script>
        var meetingDetails = @json($meeting);
        console.log("Meeting details:", meetingDetails);

        const client = ZoomMtgEmbedded.createClient();
        const meetingSDKElement = document.getElementById('meetingSDKElement');

        client.init({
            zoomAppRoot: meetingSDKElement,
            language: 'en-US',
            patchJsMedia: true,
            customize: {
                video: {
                    isResizable: false,
                    viewSizes: {
                        default: {
                            width: 1200,
                            height: 700
                        },
                        ribbon: {
                            width: 350,
                            height: 800
                        }
                    }
                },
                // Adding a share customization block to control the shared screen size
                share: {
                    isResizable: false,
                    viewSizes: {
                        default: {
                            width: 1200,
                            height: 700
                        }
                    }
                }
            }
        }).then(() => {
            fetch("{{ route('zoom.generate_signature', ['meeting_id' => $meeting['zoom_meeting_id']]) }}")
                .then(response => response.json())
                .then(data => {
                    if (!data.signature) {
                        console.error("Zoom API Error:", data.error, "Details:", data.details);
                        return;
                    }
                    console.log("Fetched signature successfully.");
                    client.join({
                        sdkKey: "40Oxf8mkRWWSzwkWzZrTJw",
                        signature: data.signature,
                        meetingNumber: meetingDetails.zoom_meeting_id,
                        password: "{{ $meeting['password'] }}",
                        userName: "{{ auth()->user()->name }}"
                    }).then(() => {
                        console.log('Joined meeting successfully!');
                    }).catch(error => {
                        if (error.reason === "Meeting has not started") {
                            swal({
                                title: "Meeting not started",
                                text: "The meeting has not started yet. Please wait a few moments and try again.",
                                icon: "warning",
                                confirmButtonColor: '#ff7918'
                            });


                        } else {
                            console.error("Join meeting error:", error);
                        }
                    });
                })
                .catch(error => console.error("Error fetching signature:", error));
        }).catch(error => {
            console.error("Init error:", error);
        });
    </script>

    <!-- Homework and Attendance Scripts -->
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

        function updateAttendance() {
            fetch("{{ route('attendance.fetch', ['meeting' => $meeting->id]) }}")
                .then(response => response.text())
                .then(text => {
                    console.log("Raw server response:", text);
                    try {
                        let data = JSON.parse(text);
                        if (!data.students || !Array.isArray(data.students)) {
                            console.error("Unexpected response format:", data);
                            return;
                        }
                        data.students.forEach(student => {
                            let statusElement = document.querySelector(
                                `#student-${student.id} .attendance-status`);
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
        setInterval(updateAttendance, 50000);
    </script>

    <!-- SweetAlert Library (include via CDN) -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    @include('include.scripts')
</body>

</html>
