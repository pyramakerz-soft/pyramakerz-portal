<!doctype html>
<html class="no-js" lang="zxx">
@include('include.head')

<body class="body__wrapper">

    {{--  @include('include.load')
    --}}

    <main class="main_wrapper overflow-hidden">
        @include('include.dash-nav')

        <div class="dashboardarea sp_bottom_100">
            @include('include.admin-topbar')
            <div class="dashboard">
                <div class="container-fluid full__width__padding">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-12">
                            @include('include.sidebar')
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-12">
                            <div class="dashboard__content__wraper">
                                <div class="dashboard__section__title">
                                    <h4>📋 Instructor Evaluations</h4>
                                </div>

                                <form action="{{ route('admin.evaluations.index') }}" method="GET" class="mb-4">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name="instructor_id" class="form-control">
                                                <option value="">Select Instructor</option>
                                                @foreach ($instructors as $instructor)
                                                    <option value="{{ $instructor->id }}"
                                                        {{ request('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                                        {{ $instructor->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <select name="date_filter" class="form-control">
                                                <option value="">Select Date Range</option>
                                                <option value="this_week"
                                                    {{ request('date_filter') == 'this_week' ? 'selected' : '' }}>This
                                                    Week
                                                </option>
                                                <option value="this_month"
                                                    {{ request('date_filter') == 'this_month' ? 'selected' : '' }}>This
                                                    Month</option>
                                                <option value="this_year"
                                                    {{ request('date_filter') == 'this_year' ? 'selected' : '' }}>This
                                                    Year
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <input type="number" name="min_percentage" class="form-control"
                                                placeholder="Min %" value="{{ request('min_percentage') }}">
                                        </div>

                                        <div class="col-md-3">
                                            <button type="submit" class="btn btn-black w-100">Filter</button>
                                        </div>
                                    </div>
                                </form>

                                <!-- Auto Evaluations Table -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="  headtb text-white">
                                            <tr>
                                                <th>Trainer</th>
                                                <th>#Sessions/Week</th>
                                                <th>#Students</th>
                                                <th>#Attended</th>
                                                <th>#Absent</th>
                                                <th>Percentage%</th>
                                                <th>Evaluation</th>
                                                <th>Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($evaluations as $evaluation)
                                                <tr>
                                                    <td>{{ $evaluation->instructor->name }}</td>
                                                    <td>{{ $evaluation->sessions_per_week }}</td>
                                                    <td>{{ $evaluation->students_count }}</td>
                                                    <td>{{ $evaluation->attended }}</td>
                                                    <td>{{ $evaluation->absent }}</td>
                                                    <td>{{ number_format($evaluation->percentage, 2) }}%</td>
                                                    <td>{{ $evaluation->evaluation }}%</td>
                                                    <td>{{ $evaluation->comment }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="8" class="text-center">No Auto Evaluations Found.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Manual Evaluations Table -->
                                <div class="dashboard__section__title mt-5">
                                    <h4>✍️ Manual Evaluations</h4>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="bg-success text-white">
                                            <tr>
                                                <th>Trainer</th>
                                                <th>Date</th>
                                                <th>Program</th>
                                                <th>Rank</th>
                                                <th>Evaluation %</th>
                                                <th>Supervisor</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($manualEvaluations as $manualEvaluation)
                                                <tr>
                                                    <td>{{ $manualEvaluation->trainer->name }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($manualEvaluation->date)->format('Y-m-d') }}
                                                    </td>
                                                    <td>{{ $manualEvaluation->program }}</td>
                                                    <td>{{ $manualEvaluation->rank }}</td>
                                                    <td>{{ number_format($manualEvaluation->evaluation_percentage, 2) }}%
                                                    </td>
                                                    <td>{{ $manualEvaluation->supervisor->name }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-black view-comments-btn"
                                                            data-id="{{ $manualEvaluation->id }}">
                                                            <i class="icofont-comment"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">No Manual Evaluations Found.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>


                                {{-- @dd($student_to_inst); --}}
                                <div class="dashboard__section__title mt-5">
                                    <h4>✍️ Student Evaluations</h4>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="bg-success text-white">
                                            <tr>
                                                <th>Student</th>
                                                <th>Instructor</th>
                                                <th>Course</th>
                                                <th>Content Quality</th>
                                                <th>Instructor Quality</th>
                                                <th>Engagment</th>
                                                <th>Pace</th>
                                                <th>Technology Usage</th>
                                                <th>Overall Experience</th>
                                                <th>Feedback</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($student_to_inst as $eval)
                                                {{-- @dd($eval->meeting->group->course->instructor->name) --}}
                                                <tr>
                                                    <td>{{ $eval->student->name }}</td>
                                                    <td>{{ $eval->meeting->group->instructor->name }}</td>
                                                    <td>{{ $eval->meeting->group->course->name }}
                                                    </td>
                                                    <td>{{ $eval->content_quality }}</td>
                                                    <td>{{ $eval->instructor_clarity }}</td>
                                                    <td>{{ $eval->engagement }}
                                                    <td>{{ $eval->pace }}
                                                    <td>{{ $eval->technology_usage }}
                                                    </td>
                                                    <td>{{ $eval->overall_experience }}</td>
                                                    <td>{{ $eval->feedback }}</td>

                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">No Manual Evaluations Found.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>




                                <div class="mt-3">
                                    <a href="{{ route('admin.instructors.index') }}" class="btn btn-outline-secondary">
                                        <i class="icofont-arrow-left"></i> Back to Instructors
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../js/vendor/jquery-3.6.0.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".view-comments-btn").click(function() {
                let evaluationId = $(this).data("id");

                $.get("{{ url('https://dev-pyramakerz.cloud/pyramakerz-portal/public/supervisor/instructors/comments') }}/" + evaluationId, function(
                    comments) {
                    let commentsHtml = comments.length ? "" : "<p>No comments yet.</p>";

                    comments.forEach(comment => {
                        commentsHtml += `<div class="comment-box">
                        <strong>${comment.supervisor}:</strong> ${comment.comment}
                        <small class="text-muted d-block">${new Date(comment.created_at).toLocaleString()}</small>
                    </div><hr>`;
                    });

                    Swal.fire({
                        title: "Manual Evaluation Comments",
                        html: `<div style="max-height: 300px; overflow-y: auto;">${commentsHtml}</div>`,
                        showCancelButton: false,
                        confirmButtonText: "Close",
                    });
                }).fail(() => {
                    Swal.fire("Error", "Could not fetch comments!", "error");
                });
            });
        });
    </script>

</body>

</html>
