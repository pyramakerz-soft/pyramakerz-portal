<!doctype html>
<html class="no-js" lang="zxx">
@include('include.head')

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

<body class="body__wrapper">

    @include('include.load')

    <main class="main_wrapper overflow-hidden">
        @include('include.dash-nav')

        <!-- Supervisor Dashboard Area -->
        <div class="dashboardarea">
            @include('include.admin-topbar')
            <div class="dashboard">
                <div class="container-fluid full__width__padding">
                    <div class="row">
                        <!-- Sidebar -->
                        <div class="col-xl-3 col-lg-3 col-md-12">
                            @include('include.sidebar')
                        </div>

                        <!-- Main Content -->
                        <div class="col-xl-9 col-lg-9 col-md-12">
                            <div class="dashboard__content__wraper">
                                <div class="dashboard__section__title">
                                    <h4>📋 Manual Evaluation</h4>
                                </div>

                                <!-- Evaluation Form -->
                                <form id="manualEvaluationForm">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Trainer Name:</label>
                                            <select class="form-control select2" id="trainer_id" name="trainer_id">
                                                <option value="">Select Trainer</option>
                                                @foreach ($trainers as $trainer)
                                                    <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Date:</label>
                                            <input type="text" class="form-control datepicker" id="date"
                                                name="date" placeholder="Select Date">
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Program:</label>
                                            <select class="form-control select2" id="program" name="program">
                                                <option value="">Select Program</option>
                                                @foreach ($programs as $program)
                                                    <option value="{{ $program->name }}">{{ $program->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Rank:</label>
                                            <select class="form-control select2" id="rank" name="rank">
                                                <option value="S">S</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <option value="F">F</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Weekly Evaluation Table -->
                                    <div class="mt-4">
                                        <h5>📊 Weekly Evaluation</h5>
                                        <table class="table table-bordered">
                                            <thead class="  headtb text-white">
                                                <tr>
                                                    <th>Evaluation Criteria</th>
                                                    <th>Score / 10</th>
                                                    <th>Comments</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $criteria = [
                                                        'Setup',
                                                        'Preparation',
                                                        'Objectives',
                                                        'Delivery Capacity',
                                                        'Controlling the Session',
                                                        'Communication with Students',
                                                        'Attendance and Evaluation Sheets',
                                                        'Personal Impact',
                                                        'Training Techniques',
                                                    ];
                                                @endphp
                                                @foreach ($criteria as $criterion)
                                                    <tr>
                                                        <td>{{ $criterion }}</td>
                                                        <td><input type="number" class="form-control score-input"
                                                                name="scores[]" min="0" max="10"
                                                                value="10"></td>
                                                        <td><input type="text" class="form-control" name="comments[]"
                                                                placeholder="Add Comment"></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Summary -->
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Evaluation Percentage %:</label>
                                            <input type="text" class="form-control" id="evaluation_percentage"
                                                name="evaluation_percentage" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Supervisor:</label>
                                            <select class="form-control" disabled>
                                                <option>{{ Auth::guard('admin')->user()->name }}</option>
                                            </select>
                                            <input type="hidden" name="supervisor"
                                                value="{{ Auth::guard('admin')->user()->name }}">
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="mt-4">
                                        <button type="submit" class="btn btn-black ">Submit Evaluation</button>
                                    </div>
                                </form>

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
        @include('include.scripts')
    </main>

    <!-- JS Dependencies -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $(".select2").each(function() {
                $(this).select2({
                    dropdownParent: $(this).parent(),
                    width: "100%",
                    theme: "classic"
                });
            });

            // Initialize Date Picker
            $(".datepicker").flatpickr({
                dateFormat: "Y-m-d",
                allowInput: true
            });

            // Calculate Evaluation Percentage
            $(".score-input").on("input", function() {
                let totalScore = 0;
                let numCriteria = $(".score-input").length;

                $(".score-input").each(function() {
                    totalScore += parseFloat($(this).val()) || 0;
                });

                let percentage = (totalScore / (numCriteria * 10)) * 100;
                $("#evaluation_percentage").val(percentage.toFixed(2) + "%");
            });

            // Submit Form
            $("#manualEvaluationForm").submit(function(e) {
                e.preventDefault();

                let formData = $(this).serialize();
                $.post("{{ route('admin.evaluations.store') }}", formData, function(response) {
                    Swal.fire({
                        title: "Success",
                        text: "Evaluation Submitted!",
                        icon: "success",
                        confirmButtonColor: "#ff7918"
                    }).then(() => location
                        .reload());
                }).fail(function() {
                    Swal.fire({
                        title: "Error",
                        text: "Failed to submit evaluation!",
                        icon: "error",
                        confirmButtonColor: "#ff7918"
                    });
                });
            });
        });
    </script>




    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 with improved styling
            $(".select2").each(function() {
                $(this).select2({
                    dropdownParent: $(this).parent(),
                    width: "100%", // Ensures dropdown fits correctly
                    theme: "classic" // Select2 styling fix
                });
            });

            // Initialize Flatpickr for date selection
            $(".datepicker").flatpickr({
                dateFormat: "Y-m-d",
                allowInput: true // Allows users to manually enter the date
            });

            // Calculate Evaluation Percentage Dynamically
            $(".score-input").on("input", function() {
                let totalScore = 0;
                let numCriteria = $(".score-input").length;

                $(".score-input").each(function() {
                    let value = parseFloat($(this).val()) || 0; // Default to 0 if empty
                    totalScore += value;
                });

                let percentage = (totalScore / (numCriteria * 10)) * 100;
                $("#evaluation_percentage").val(percentage.toFixed(2) + "%");
            });

            // Form Submission with Validation
            $("#manualEvaluationForm").submit(function(e) {
                e.preventDefault();

                let scores = [];
                $(".score-input").each(function() {
                    scores.push($(this).val() || 0);
                });

                let comments = [];
                $("input[name='comments[]']").each(function() {
                    comments.push($(this).val().trim());
                });

                let formData = {
                    _token: "{{ csrf_token() }}",
                    trainer_id: $("#trainer_id").val(),
                    date: $("#date").val(),
                    program: $("#program").val(),
                    rank: $("#rank").val(),
                    scores: scores,
                    comments: comments
                };

                $.post("{{ route('admin.evaluations.store') }}", formData)
                    .done(function() {
                        Swal.fire({
                            title: "Success",
                            text: "Evaluation Submitted!",
                            icon: "success",
                            confirmButtonColor: "#ff7918"
                        }).then(() => location
                            .reload());
                    })
                    .fail(function(xhr) {
                        let errorMessage = xhr.responseJSON?.message || "Failed to submit evaluation!";
                        Swal.fire({
                            title: "Error",
                            text: errorMessage,
                            icon: "error",
                            confirmButtonColor: "#ff7918"
                        });
                    });
            });
        });
    </script>

</body>

</html>
