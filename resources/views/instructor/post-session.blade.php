<!DOCTYPE html>
<html class="no-js " lang="zxx">



<head>
    @include('include.head')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

</head>

<body class="body__wrapper">



    {{-- @include('include.load') --}}


    <main class="main_wrapper overflow-hidden">
        @include('include.nav')

        <div class="breadcrumbarea breadcrumbarea--2 sp_bottom_100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="breadcrumb__content__wraper">
                            <div class="breadcrumb__inner text-start">
                                <ul>
                                    <li><a href="/">Home</a></li>
                                    <li>
                                        <a href="{{ route('instructor.course_details', $meeting->group->course->id) }}">
                                            {{ $meeting->group->course->name }} (ID:
                                            pyra-{{ $meeting->group->course->id }})
                                        </a>
                                    </li>
                                    <li>{{ $meeting->group->name }}</li>
                                    <li>Post Session Evaluation</li>
                                </ul>
                            </div>
                        </div>
                        <div class="course__details__heading">
                            <h3>Post Session Evaluation</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="dashboard">
            <div class="container-fluid full__width__padding">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-12">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                @include('include.sidebar')
                            </div>
                            <!-- Sidebar: Session Details -->
                            <div class="col-xl-12 col-lg-12">
                                <div class="dashboard__single__counter" style="color:black !important">
                                    <h3>Session Details</h3>
                                    <p><strong>Date:</strong>
                                        {{ \Carbon\Carbon::parse($meeting->start_time)->format('M d, Y') }}
                                    </p>
                                    <p><strong>Duration:</strong> {{ $meeting->duration }} mins</p>
                                    <p><strong>Group:</strong> {{ $meeting->group->name ?? 'N/A' }}</p>
                                    <p><strong>Lesson:</strong> {{ $meeting->lesson->title ?? 'N/A' }}</p>
                                    <p><strong>Course:</strong> {{ $meeting->group->course->name ?? 'N/A' }} (ID:
                                        pyra-{{ $meeting->group->course->id }})</p>
                                    {{-- <a href="{{ $meeting->zoom_join_url }}" target="_blank"
                                class="btn dashboard__small__btn__2  btn-block">
                                Review Session Recording
                            </a> --}}
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="  headtb text-white">
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Absent?</th>
                                        <th>Interaction</th>
                                        <th>Performance</th>
                                        <th>Homework</th>
                                        <th>Date Joined</th>
                                        <th>Current Evaluation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($meeting->group->students as $student)
                                        <tr>
                                            <td>{{ $student->name }}</td>
                                            <td>
                                                <input type="checkbox" class="absent-checkbox" data-student="{{ $student->id }}">
                                                <!-- Hidden field to capture attendance status -->
                                                <input type="hidden" name="evaluations[{{ $student->id }}][attendance]" class="attendance-field" data-student="{{ $student->id }}" value="present">
                                            </td>
                                            <td>
                                                <select name="evaluations[{{ $student->id }}][interaction]" class="form-control eval-field" data-student="{{ $student->id }}">
                                                    <option value="Excellent">Excellent</option>
                                                    <option value="Very Good">Very Good</option>
                                                    <option value="Good">Good</option>
                                                    <option value="Fair">Fair</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="evaluations[{{ $student->id }}][performance]" class="form-control eval-field" data-student="{{ $student->id }}">
                                                    <option value="Excellent">Excellent</option>
                                                    <option value="Very Good">Very Good</option>
                                                    <option value="Good">Good</option>
                                                    <option value="Fair">Fair</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="evaluations[{{ $student->id }}][homework]" class="form-control eval-field" data-student="{{ $student->id }}">
                                                    <option value="Submitted homework">Submitted homework</option>
                                                    <option value="Didn't submit homework">Didn't submit homework</option>
                                                    <option value="No homework">No homework</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="date" name="evaluations[{{ $student->id }}][joined_at]" class="form-control eval-field" data-student="{{ $student->id }}"
                                                       value="{{ optional($student->groupStudent)->created_at ? $student->groupStudent->created_at->format('Y-m-d') : '' }}">
                                            </td>
                                            <td>
                                                @if(isset($evaluations) && $student->id)
                                                    <button type="button" class="btn btn-custom view-eval-btn" data-student="{{ $student->id }}">
                                                        View Current Evaluation
                                                    </button>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            </div>

                        </div>

                    </div>


                    <!-- Main Panel: Evaluation & Resource Upload -->

                    <div class="col-xl-8 col-lg-8">
                        <div class="dashboard__content__wraper">
                            @if (Auth::guard('admin')->user()->can('instructortostudentevaluation-create'))
                                <div class="evaluation-section">
                                    <h5>Evaluate Students</h5>
                                    <form action="{{ route('instructor.evaluate_session', $meeting->id) }}"
                                        method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="evaluation_period">Evaluation Period</label>
                                            <div class="row">
                                                <div class="col">
                                                    <input type="date" name="evaluation_period_start"
                                                        class="form-control" required>
                                                </div>
                                                <div class="col">
                                                    <input type="date" name="evaluation_period_end"
                                                        class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead class="  headtb text-white">
                                                    <tr>
                                                        <th>Student Name</th>
                                                        <th>Absent?</th>
                                                        <th>Interaction</th>
                                                        <th>Performance</th>
                                                        <th>Homework</th>
                                                        <th>Date Joined</th>
                                                        <th>Current Evaluation</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($meeting->group->students as $student)
                                                        <tr>
                                                            <td>{{ $student->name }}</td>
                                                            <td>
                                                                <input type="checkbox" class="absent-checkbox"
                                                                    data-student="{{ $student->id }}">
                                                                <!-- Hidden field to capture attendance status -->
                                                                <input type="hidden"
                                                                    name="evaluations[{{ $student->id }}][attendance]"
                                                                    class="attendance-field"
                                                                    data-student="{{ $student->id }}" value="present">
                                                            </td>
                                                            <td>
                                                                <select
                                                                    name="evaluations[{{ $student->id }}][interaction]"
                                                                    class="form-control eval-field"
                                                                    data-student="{{ $student->id }}">
                                                                    <option value="Excellent">Excellent</option>
                                                                    <option value="Very Good">Very Good</option>
                                                                    <option value="Good">Good</option>
                                                                    <option value="Fair">Fair</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select
                                                                    name="evaluations[{{ $student->id }}][performance]"
                                                                    class="form-control eval-field"
                                                                    data-student="{{ $student->id }}">
                                                                    <option value="Excellent">Excellent</option>
                                                                    <option value="Very Good">Very Good</option>
                                                                    <option value="Good">Good</option>
                                                                    <option value="Fair">Fair</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <select
                                                                    name="evaluations[{{ $student->id }}][homework]"
                                                                    class="form-control eval-field"
                                                                    data-student="{{ $student->id }}">
                                                                    <option value="Submitted homework">Submitted
                                                                        homework</option>
                                                                    <option value="Didn't submit homework">Didn't submit
                                                                        homework</option>
                                                                    <option value="No homework">No homework</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="date"
                                                                    name="evaluations[{{ $student->id }}][joined_at]"
                                                                    class="form-control eval-field"
                                                                    data-student="{{ $student->id }}"
                                                                    value="{{ optional($student->groupStudent)->created_at ? $student->groupStudent->created_at->format('Y-m-d') : '' }}">
                                                            </td>
                                                            <td>
                                                                @if (isset($evaluations) && $student->id)
                                                                    <button type="button"
                                                                        class="btn btn-custom view-eval-btn"
                                                                        data-student="{{ $student->id }}">
                                                                        View Current Evaluation
                                                                    </button>
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <button type="submit" class="btn default__button">Save Evaluation</button>
                                    </form>
                                </div>
                            @endif


                        </div>
                    </div>
                    <!-- Upload Resources Section (unchanged) -->
                    {{-- @if (Auth::guard('admin')->user()->can('lessonresource-create'))
                    <div class="upload-section mt-4">
                        <h5>Upload Session Handouts / Resources</h5>
                        <form id="uploadResourceForm" action="{{ route('lesson.uploadMaterial') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="lesson_id">Lesson</label>
                                <select name="lesson_id" id="lesson_id" class="form-control">
                                    <option value="{{ $meeting->lesson->id }}">{{ $meeting->lesson->title }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="resource_type">Resource Type</label>
                                <select name="resource_type" id="resource_type" class="form-control">
                                    <option value="">Select Resource Type</option>
                                    <option value="pdf">PDF</option>
                                    <option value="doc">Document (DOC/DOCX)</option>
                                    <option value="ppt">Presentation (PPT/PPTX)</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="title">Resource Title</label>
                                <input type="text" name="title" id="title" class="form-control" placeholder="Enter resource title">
                            </div>
                            <div class="form-group">
                                <label for="description">Resource Description</label>
                                <textarea name="description" id="description" rows="3" class="form-control" placeholder="Enter description (optional)"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="material">Choose File</label>
                                <input type="file" name="material" id="material" class="form-control">
                            </div>
                            <input type="hidden" name="group_id" value="{{ $meeting->group->id }}">
                            <input type="hidden" name="group_schedule_id" value="{{ $meeting->group_schedule_id }}">
                            <button type="submit" class="btn btn-custom mt-2">Upload Resource</button>
                        </form>
                    </div>
                    @endif --}}
                </div>
            </div>
    </main>

    @include('include.footer')
    @include('include.scripts')

    <!-- JS Scripts -->

    <script>
        $(document).ready(function() {
            $("#lesson_id").select2({
                width: "100%"
            });

            // Update the hidden attendance field when the Absent checkbox changes.
            $('.absent-checkbox').on('change', function() {
                let studentId = $(this).data('student');
                if ($(this).is(':checked')) {
                    $(`.attendance-field[data-student="${studentId}"]`).val('absent');
                    $(`.eval-field[data-student="${studentId}"]`).prop('disabled', true);
                } else {
                    $(`.attendance-field[data-student="${studentId}"]`).val('present');
                    $(`.eval-field[data-student="${studentId}"]`).prop('disabled', false);
                }
            });


            // Handle resource upload form submission via AJAX
            $('#uploadResourceForm').on('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire("Success", response.message, "success").then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire("Error", xhr.responseJSON.message || "Upload failed!",
                            "error");
                    }
                });
            });

            // Handle the "View Current Evaluation" button popup
            $('.view-eval-btn').on('click', function() {
                let studentId = $(this).data('student');
                // For simplicity, we'll assume evaluation details are rendered as JSON in a data attribute
                // Alternatively, you could perform an AJAX call to load details for that student.
                @php
                    // Prepare an array mapping student ID to evaluation details (if exists)
                    $evalMap = [];
                    if (isset($evaluations)) {
                        foreach ($evaluations as $eval) {
                            // We show the latest session evaluation
                            $latest = collect($eval->evaluation_details)->last();
                            $evalMap[$eval->student_id] = $latest;
                        }
                    }
                @endphp
                let evalData = @json($evalMap);
                let details = evalData[studentId];
                if (details) {
                    Swal.fire({
                        title: "Current Evaluation",
                        html: `
                            <p><strong>Interaction:</strong> ${details.interaction || 'N/A'}</p>
                            <p><strong>Performance:</strong> ${details.performance || 'N/A'}</p>
                            <p><strong>Homework:</strong> ${details.homework || 'N/A'}</p>
                            <p><strong>Session Score:</strong> ${details.session_score || 'N/A'}</p>
                            <p><strong>Evaluated At:</strong> ${details.evaluated_at || 'N/A'}</p>
                        `
                    });
                } else {
                    Swal.fire("No Evaluation", "No evaluation data available for this student.", "info");
                }
            });
        });
    </script>





</body>

</html>
