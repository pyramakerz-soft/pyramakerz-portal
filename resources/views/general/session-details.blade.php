<!doctype html>
<html class="no-js" lang="zxx">
@include('include.head')

<body class="body__wrapper">
    @include('include.load')
    <main class="main_wrapper overflow-hidden">
        @include('include.dash-nav')

        <div class="dashboardarea">
            @include('include.stud-topbar')
            <div class="dashboard">
                <div class="container-fluid full__width__padding">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-12">
                            @include('include.sidebar')
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-12">
                            <div class="dashboard__content__wraper">
                                <div class="dashboard__section__title">
                                    <div class="row"><h4>Course: {{ $group->course->name }} - {{ $schedule->lesson->coursePath->name }} - {{ $schedule->lesson->pathOfPath ? $schedule->lesson->pathOfPath->name : '' }} - {{ $group->name }}</h4></div>
                                    <br>
                                    <div class="row"><h4>Instructor: {{ $group->instructor->name }}</h4></div>
                                    <div class="row"><h4>Lesson: {{ $schedule->lesson->title ?? 'N/A' }}</h4></div>
                                    {{-- <h4>Session Date: {{ $schedule->date ?? 'N/A' }}</h4> --}}
                                </div>

                                <!-- Progress Table -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead class="headtb text-white">
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Date</th>
                                                <th>Absent</th>
                                                <th>Interaction</th>
                                                <th>Performance</th>
                                                <th>Homework</th>
                                                <th>Project</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $hasEvaluations = false; @endphp
                                            @foreach ($students as $student)
                                                @php
                                                    // Get evaluation for the student (if exists)
                                                    $evaluation = $evaluations[$student->student_id] ?? null;

                                                    // Ensure evaluation_details is a proper array
                                                    $evaluationDetails = is_array($evaluation->evaluation_details ?? null) 
                                                        ? $evaluation->evaluation_details 
                                                        : (is_string($evaluation->evaluation_details ?? null) 
                                                            ? json_decode($evaluation->evaluation_details, true) 
                                                            : []);

                                                    // Check if the student was absent
                                                    $isAbsent = is_array($evaluationDetails) && isset($evaluationDetails[0]['interaction']) 
                                                        && $evaluationDetails[0]['interaction'] === 'Absent';

                                                    if ($evaluation) {
                                                        $hasEvaluations = true;
                                                    }
                                                @endphp

                                                @if ($evaluation)
                                                    <tr>
                                                        <td>{{ $student->student->name }}</td>
                                                        <td>{{ $evaluation->joined_at ?? 'N/A' }}</td>
                                                        <td class="{{ $isAbsent ? 'text-danger' : 'text-success' }}">
                                                            {{ $isAbsent ? '❌ Absent' : '✔️ Present' }}
                                                        </td>
                                                        <td>{{ $evaluationDetails[0]['interaction'] ?? 'N/A' }}</td>
                                                        <td>{{ $evaluationDetails[0]['performance'] ?? 'N/A' }}</td>
                                                        <td>{{ $evaluationDetails[0]['homework'] ?? 'N/A' }}</td>
                                                        <td>{{ $evaluationDetails[0]['project'] ?? 'N/A' }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                            @if (!$hasEvaluations)
                                                <tr>
                                                    <td colspan="7" class="text-center text-warning">
                                                        No evaluations added yet.
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                                <div class="mt-3">
                                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                        <i class="icofont-arrow-left"></i> Back to Dashboard
                                    </a>
                                </div>
                            </div> 
                        </div> 
                    </div> 
                </div>
            </div>
        </div>
    </main>
</body>

<script src="{{ asset('js/vendor/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
@include('include.scripts')
</html>
