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

        /* Embedded Zoom element */
        #meetingSDKElement {
            width: 100%;
            flex: 1;
        }

        /* Sidebar for session details and student list */
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

        /* Session Details */
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

        /* Student List */
        .student-list {
            list-style: none;
            padding: 0;
            max-height: 300px;
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

        .attendance-status {
            margin-right: 10px;
        }

        .present {
            color: #28a745;
            font-weight: bold;
        }

        .absent {
            color: #dc3545;
            font-weight: bold;
        }

        /* Button styles */
        .action-btn {
            padding: 5px 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
            font-size: 0.9em;
        }

        .present-btn {
            background: #28a745;
            color: #fff;
        }

        .absent-btn {
            background: #dc3545;
            color: #fff;
        }

        .view-homework-btn {
            background: #f8d210;
            color: #333;
        }

        .action-btn:hover {
            opacity: 0.9;
        }

        /* Homework Modal & Overlay (if needed) */
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

        #homeworkModal button {
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
        }

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
    <!-- Zoom SDK dependencies -->
    <script src="https://source.zoom.us/3.6.0/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/3.6.0/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/3.6.0/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/3.6.0/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/3.6.0/lib/vendor/lodash.min.js"></script>
    <!-- Embedded Component SDK -->
    <script src="https://source.zoom.us/zoom-meeting-embedded-3.6.0.min.js"></script>
    <!-- SweetAlert Library -->
    @include('include.scripts')

    <main class="main_wrapper overflow-hidden">
        @include('include.admin-topbar')
        <div class="zoom-container">
            <!-- Zoom Meeting Frame (Embedded SDK) -->
            <div class="zoom-frame">
                <div id="meetingSDKElement"></div>
            </div>
            <!-- Sidebar: Session Details and Student List for Instructor -->
            <div class="sidebar">
                <div>
                    <h5>📝 Session Details</h5>
                    <p><strong>📅 Date:</strong> {{ \Carbon\Carbon::parse($meeting->start_time)->format('M d, Y') }}</p>
                    <p><strong>⏳ Duration:</strong> {{ $meeting->duration }} mins</p>
                    <p><strong>👨‍🎓 Group:</strong> {{ $meeting->group->name ?? 'N/A' }}</p>

                </div>
                <div>
                    <h5>🎓 Students</h5>
                    <ul class="student-list">
                        @foreach ($meeting->group->students as $student)
                            <li id="student-{{ $student->id }}">
                                <span>{{ $student->name }}</span>
                                <span class="attendance-status {{ $student->attendance ? 'present' : 'absent' }}">
                                    {{ $student->attendance ? '✔️ Present' : '❌ Absent' }}
                                </span>
                                <!-- If the student has uploaded homework, show "View Homework"; else show attendance buttons -->
                                @if ($student->homework_uploaded)
                                    <button class="action-btn view-homework-btn"
                                        onclick="viewHomework({{ $student->id }})">View Homework</button>
                                @else
                                    <button class="action-btn present-btn"
                                        onclick="markAttendance({{ $student->id }}, 1)">Mark Present</button>
                                    <button class="action-btn absent-btn"
                                        onclick="markAttendance({{ $student->id }}, 0)">Mark Absent</button>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- (Optional) Homework Upload Modal for instructor if needed -->
        <div class="overlay" id="overlay" onclick="closeModal()"></div>
        <div id="homeworkModal">
            <h4>📂 Homework Details</h4>
            <div id="homeworkContent">
                <!-- Homework details will be loaded here -->
            </div>
            <button onclick="closeModal()">Close</button>
        </div>
    </main>

    <!-- Zoom Meeting SDK Embedded Script -->
    <script>
        var meetingDetails = @json($meeting);
        console.log("Meeting details:", meetingDetails);

        const client = ZoomMtgEmbedded.createClient();
        const meetingSDKElement = document.getElementById('meetingSDKElement');

        // Initialize with customized video & share sizes
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
            fetch("{{ route('zoom.generate_host_signature', ['meeting_id' => $meeting['zoom_meeting_id']]) }}")
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
                        userName: "{{ Auth::guard('admin')->user()->name }}"
                    }).then(() => {
                        console.log('Joined meeting successfully!');
                    }).catch(error => {
                        if (error.reason === "Meeting has not started") {
                            swal("Meeting not started",
                                "The meeting has not started yet. Please wait a few moments and try again.",
                                "info");
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
    
    <!-- Instructor-Specific Scripts -->
    <script>
        // Mark a student's attendance. status: 1 = Present, 0 = Absent.
        function markAttendance(studentId, status) {
            fetch("{{ route('instructor.attendance.update') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        student_id: studentId,
                        status: status,
                        meeting_id: "{{ $meeting['id'] }}"
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                        title: "Attendance Updated",
                        text: data.message,
                        icon: "success"
                    });

                        // Optionally, update the student's status in the UI.
                        let statusEl = document.querySelector(`#student-${studentId} .attendance-status`);
                        if (statusEl) {
                            statusEl.innerText = status === 1 ? '✔️ Present' : '❌ Absent';
                            statusEl.className = "attendance-status " + (status === 1 ? 'present' : 'absent');
                        }
                    } else {
                        Swal.fire({
                        title: "Error",
                        text: data.message,
                        icon: "error"
                    });

                    }
                })
                .catch(error => {
                    console.error("Attendance update error:", error);
                    swal("Error", "There was a problem updating attendance.", "error");
                });
        }

        // View the student's homework. This could open a modal with homework details.
        function viewHomework(studentId) {
            // For example, fetch the homework details via AJAX.
            fetch("{{ route('instructor.homework.view') }}?student_id=" + studentId + "&meeting_id={{ $meeting['id'] }}")
                .then(response => response.json())
                .then(data => {
                    if (data.homework) {
                        document.getElementById('homeworkContent').innerHTML = data.homework;
                        document.getElementById('overlay').style.display = 'block';
                        document.getElementById('homeworkModal').style.display = 'block';
                    } else {
                        swal("No Homework", "This student has not uploaded any homework.", "info");
                    }
                })
                .catch(error => {
                    console.error("Error fetching homework:", error);
                    swal("Error", "Could not load homework details.", "error");
                });
        }

        function closeModal() {
            document.getElementById('homeworkModal').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }

        // (Optional) Function to update attendance periodically if needed.
        function updateAttendance() {
            fetch("{{ route('attendance.fetch', ['meeting' => $meeting->id]) }}")
                .then(response => response.json())
                .then(data => {
                    // Update each student's attendance in the UI
                    data.students.forEach(student => {
                        let statusEl = document.querySelector(`#student-${student.id} .attendance-status`);
                        if (statusEl) {
                            statusEl.innerText = student.is_present ? '✔️ Present' : '❌ Absent';
                            statusEl.className = "attendance-status " + (student.is_present ? 'present' :
                                'absent');
                        }
                    });
                })
                .catch(error => console.error("Error fetching attendance:", error));
        }
        setInterval(updateAttendance, 60000); // Update every 60 seconds
    </script>

    <!-- (Optional) Homework Upload Scripts for instructor if needed -->
    <script>
        function uploadHomework() {
            document.getElementById('homeworkModal').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }
    </script>
</body>

</html>
