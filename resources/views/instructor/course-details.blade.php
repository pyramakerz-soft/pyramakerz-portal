<!doctype html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')
</head>

<body class="body__wrapper">
    @include('include.preload')

    <main class="main_wrapper overflow-hidden">
        @include('include.nav')

        <!-- theme fixed shadow -->
        <div>
            <div class="theme__shadow__circle"></div>
            <div class="theme__shadow__circle shadow__right"></div>
        </div>
        <!-- theme fixed shadow -->

        <!-- breadcrumbarea__section__start -->
        <div class="breadcrumbarea breadcrumbarea--2">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="breadcrumb__content__wraper" data-aos="fade-up">
                            <div class="breadcrumb__inner text-start">
                                <ul>
                                    <li><a href="/">Home</a></li>
                                    <li>{{ $course->name ?? 'Course Details' }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="course__details__top--2">
                            <div class="course__button__wraper" data-aos="fade-up">
                                <div class="course__button">
                                    <a href="#">Featured</a>
                                    <a class="course__2" href="#">{{ $course->skill_level ?? 'N/A' }}</a>
                                </div>
                            </div>
                            <div class="course__details__heading" data-aos="fade-up">
                                <h3>{{ $course->name ?? 'Course Title' }}</h3>

                                <a class="btn btn-black btn-sm" href="{{ route('instructor.groups', $course->id) }}">
                                    <i class="icofont-users"></i> View Groups
                                </a>
                            </div>

                            <div class="course__details__price" data-aos="fade-up">
                                <ul>
                                    <li>
                                        <div class="course__details__date">
                                            <i class="icofont-book-alt"></i>
                                            {{ isset($course) ? $course->totalLessonsCount() : 0 }} Lessons
                                        </div>
                                    </li>
                                    <li>
                                        <div class="course__star">
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <span>(44 Reviews)</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="shape__icon__2">
                <img loading="lazy" class="shape__icon__img shape__icon__img__1"
                    src="{{ asset('img/herobanner/herobanner__1.png') }}" alt="photo">
                <img loading="lazy" class="shape__icon__img shape__icon__img__2"
                    src="{{ asset('img/herobanner/herobanner__2.png') }}" alt="photo">
                <img loading="lazy" class="shape__icon__img shape__icon__img__3"
                    src="{{ asset('img/herobanner/herobanner__3.png') }}" alt="photo">
                <img loading="lazy" class="shape__icon__img shape__icon__img__4"
                    src="{{ asset('img/herobanner/herobanner__5.png') }}" alt="photo">
            </div>
        </div>
        <!-- breadcrumbarea__section__end-->

        <div class="blogarea__2 sp_top_100 sp_bottom_100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-8">
                        <div class="blog__details__content__wraper">
                            <div class="course__details__tab__wrapper" data-aos="fade-up">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <ul class="nav course__tap__wrap" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="single__tab__link active" data-bs-toggle="tab"
                                                    data-bs-target="#lessons" type="button">
                                                    <i class="icofont-book-alt"></i> Lessons
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="single__tab__link" data-bs-toggle="tab"
                                                    data-bs-target="#description" type="button">
                                                    <i class="icofont-paper"></i> Description
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content tab__content__wrapper" id="myTabContent">
                                    <!-- Lessons Tab -->
                                    <!-- Lessons Tab -->
                                    <div class="tab-pane fade active show" id="lessons" role="tabpanel">
                                        <div class="accordion content__cirriculum__wrap" id="accordionExample">
                                            @if (isset($course))
                                                @forelse ($course->coursePaths as $path)
                                                    @foreach ($path->lessons as $lesson)
                                                        <div class="accordion-item roundd">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#lesson{{ $lesson->id }}"
                                                                    aria-expanded="false"
                                                                    aria-controls="lesson{{ $lesson->id }}">
                                                                    {{ $lesson->title }}
                                                                    <span>Order: {{ $lesson->order ?? 'N/A' }}</span>

                                                                    <!-- Add Material Icon -->
                                                                    <i class="icofont-plus-circle add-material-btn"
                                                                        data-lesson-id="{{ $lesson->id }}"
                                                                        title="Add Material"
                                                                        style="cursor: pointer; margin-left: auto; font-size: 1.2rem;">
                                                                    </i>

                                                                    <!-- Choose Date Button -->
                                                                    @if ($lesson->lesson_date && $lesson->lesson_time)
                                                                        <button class="btn btn-outline-success btn-sm"
                                                                            disabled
                                                                            style="float:right;color:white;font-weight:bold;">
                                                                            Scheduled on {{ $lesson->lesson_date }} at
                                                                            {{ $lesson->lesson_time }}
                                                                        </button>
                                                                    @else
                                                                        <button
                                                                            class="btn btn-outline-info btn-sm choose-date-btn"
                                                                            data-lesson-id="{{ $lesson->id }}"
                                                                            style="margin-left: 10px;">
                                                                            Choose Date
                                                                        </button>
                                                                    @endif
                                                                </button>
                                                            </h2>
                                                            <div id="lesson{{ $lesson->id }}"
                                                                class="accordion-collapse collapse"
                                                                data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    <!-- Lesson Video -->
                                                                    <div class="video-container mb-3">
                                                                        @if ($lesson->video_url)
                                                                            <iframe src="{{ $lesson->video_url }}"
                                                                                width="100%" height="400"
                                                                                frameborder="0"
                                                                                allowfullscreen></iframe>
                                                                        @else
                                                                            <p>No video available for this lesson.</p>
                                                                        @endif
                                                                    </div>
                                                                    <!-- Lesson Description -->
                                                                    <p><strong>Description:</strong>
                                                                        {{ $lesson->description ?? 'No description available.' }}
                                                                    </p>
                                                                    <!-- Lesson Resource -->
                                                                    @if ($lesson->resource_file)
                                                                        <a href="{{ asset('storage/' . $lesson->resource_file) }}"
                                                                            download>
                                                                            Download Resource
                                                                        </a>
                                                                    @else
                                                                        <p>No resources available for this lesson.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @empty
                                                    <p>No lessons available for this course.</p>
                                                @endforelse
                                            @endif
                                        </div>

                                        <!-- Add Lesson Button -->
                                        <button class="btn btn-outline-primary mt-3 add-lesson-btn">
                                            <i class="icofont-plus"></i> Add Lesson
                                        </button>
                                    </div>


                                    <!-- Description Tab -->
                                    <div class="tab-pane fade" id="description" role="tabpanel">
                                        <div class="experence__heading">
                                            <h5>Course Description</h5>
                                        </div>
                                        <div class="experence__description">
                                            <p>{{ $course->description ?? 'No description available for this course.' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-xl-4 col-lg-4">
                        <div class="course__details__sidebar--2">
                            <div class="event__sidebar__wraper" data-aos="fade-up">
                                <div class="blogarae__img__2 course__details__img__2" data-aos="fade-up">
                                    <img loading="lazy"
                                        src="{{ $course->image ? asset('storage/' . $course->image) : asset('img/course.jpg') }}"
                                        alt="blog">
                                </div>

                                {{-- <div class="course__summery__button">
                                    <a class="default__button" href="#">Enroll Now</a>
                                </div> --}}

                                <div class="course__summery__lists">
                                    <ul>
                                        <li>
                                            <div class="course__summery__item">
                                                <span class="sb_label">Instructor:</span>
                                                <span class="sb_content">
                                                    @if ($course->instructor)
                                                        {{ $course->instructor->name }}
                                                        <button
                                                            class="btn btn-sm btn-outline-warning assign-teacher-btn"
                                                            data-course-id="{{ $course->id }}"
                                                            style="border: none;">
                                                            Change Instructor
                                                        </button>
                                                    @else
                                                        <button
                                                            class="btn btn-sm btn-outline-success assign-teacher-btn"
                                                            data-course-id="{{ $course->id }}"
                                                            style="border: none;">
                                                            + Assign Instructor
                                                        </button>
                                                    @endif
                                                </span>
                                            </div>

                                        </li>
                                        <li>
                                            <div class="course__summery__item">
                                                <span class="sb_label">Skill Level:</span>
                                                <span class="sb_content">{{ $course->skill_level ?? 'N/A' }}</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="course__summery__item">
                                                <span class="sb_label">Language:</span>
                                                <span class="sb_content">{{ $course->language ?? 'N/A' }}</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer__section__start -->
        @include('include.footer')
        <!-- footer__section__end -->
    </main>

    <!-- JS here -->
    <script src="{{ asset('js/vendor/modernizr-3.5.0.min.js') }}"></script>
    <script src="{{ asset('js/vendor/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <script src="{{ asset('js/jquery.meanmenu.min.js') }}"></script>
    <script src="{{ asset('js/ajax-form.js') }}"></script>
    <script src="{{ asset('js/wow.min.js') }}"></script>
    <script src="{{ asset('js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/waypoints.min.js') }}"></script>
    <script src="{{ asset('js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $(".choose-date-btn").click(function() {
                let lessonId = $(this).data("lesson-id");

                Swal.fire({
                    title: "Choose Lesson Date & Time",
                    html: `
            <input type="text" id="lesson_date" class="swal2-input" placeholder="Select Date" readonly>
            <input type="time" id="lesson_time" class="swal2-input" placeholder="Select Time">
        `,
                    didOpen: () => {
                        flatpickr("#lesson_date", {
                            enableTime: false,
                            dateFormat: "Y-m-d"
                        });
                    },
                    showCancelButton: true,
                    confirmButtonText: "Save",
                    preConfirm: () => {
                        return {
                            lesson_id: lessonId,
                            date: $("#lesson_date").val(),
                            time: $("#lesson_time").val()
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('lesson.schedule') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                lesson_id: result.value.lesson_id,
                                date: result.value.date,
                                time: result.value.time
                            },
                            success: function() {
                                Swal.fire("Success", "Lesson date saved!", "success");
                            },
                            error: function(xhr) {
                                let errorMessage = "Something went wrong!";

                                // Extract validation errors if available
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                } else if (xhr.responseJSON && xhr.responseJSON
                                    .errors) {
                                    let errors = Object.values(xhr.responseJSON.errors)
                                        .flat();
                                    errorMessage = errors.join(
                                    "<br>"); // Join multiple errors
                                }

                                Swal.fire({
                                    icon: "error",
                                    title: "Validation Error",
                                    html: errorMessage
                                });
                            }
                        });
                    }
                });
            });

            // 🔹 ADD NEW LESSON
            $(".add-lesson-btn").click(function() {
                Swal.fire({
                    title: "Add New Lesson",
                    html: `
        <div style="display: flex; flex-direction: column; gap: 10px; text-align: left;">
            
            <label style="font-weight: 600;">Lesson Title</label>
            <input type="text" id="lesson_title" class="swal2-input" placeholder="Enter Lesson Title" style="border-radius: 8px;">

            <label style="font-weight: 600;">Order Number</label>
            <input type="number" id="lesson_order" class="swal2-input" placeholder="Enter Order Number" style="border-radius: 8px;">

            <label style="font-weight: 600;">Video URL</label>
            <input type="url" id="lesson_video" class="swal2-input" placeholder="Enter Video URL" style="border-radius: 8px;">

            <label style="font-weight: 600;">Course Path</label>
            <select id="course_path_id" class="swal2-input" onchange="updatePathOfPath()" style="border-radius: 8px; padding: 8px;">
                <option value="">Select Course Path</option>
                @foreach ($course->coursePaths ?? [] as $path)
                    <option value="{{ $path->id }}" data-paths='@json($path->paths)'>{{ $path->name }}</option>
                @endforeach
            </select>

            <label style="font-weight: 600;">Path of Path</label>
            <select id="path_of_path_id" class="swal2-input" style="border-radius: 8px; padding: 8px;">
                <option value="">Select Path of Path</option>
            </select>

        </div>
    `,
                    showCancelButton: true,
                    confirmButtonText: "Save",
                    confirmButtonColor: "#28a745",
                    cancelButtonColor: "#dc3545",
                    customClass: {
                        popup: 'swal-wide',
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger',
                    },
                    preConfirm: () => {
                        return {
                            title: $("#lesson_title").val(),
                            order: $("#lesson_order").val(),
                            video_url: $("#lesson_video").val(),
                            course_path_id: $("#course_path_id").val(),
                            path_of_path_id: $("#path_of_path_id").val(),
                            course_id: {{ $course->id }}
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('lesson.store') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                title: result.value.title,
                                order: result.value.order,
                                video_url: result.value.video_url,
                                course_path_id: result.value.course_path_id,
                                path_of_path_id: result.value.path_of_path_id,
                                course_id: result.value.course_id
                            },
                            success: function() {
                                Swal.fire("Success", "Lesson added successfully!",
                                    "success");
                                location.reload();
                            },
                            error: function() {
                                Swal.fire("Error", "Something went wrong!", "error");
                            }
                        });
                    }
                });
            });


            // 🔹 ADD MATERIAL TO LESSON
            $(".add-material-btn").click(function() {
                let lessonId = $(this).data("lesson-id");

                Swal.fire({
                    title: "Upload Material",
                    html: `
                    <input type="file" id="lesson_material" class="swal2-input">
                `,
                    showCancelButton: true,
                    confirmButtonText: "Upload",
                    preConfirm: () => {
                        return {
                            lesson_id: lessonId,
                            material: $("#lesson_material")[0].files[0]
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let formData = new FormData();
                        formData.append("_token", "{{ csrf_token() }}");
                        formData.append("lesson_id", result.value.lesson_id);
                        formData.append("material", result.value.material);

                        $.ajax({
                            url: "{{ route('lesson.uploadMaterial') }}",
                            type: "POST",
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: function() {
                                Swal.fire("Success", "Material uploaded successfully!",
                                    "success");
                                location.reload();
                            },
                            error: function() {
                                Swal.fire("Error", "Upload failed!", "error");
                            }
                        });
                    }
                });
            });

            // 🔹 ASSIGN TEACHER
            $(".assign-teacher-btn").click(function() {
                let courseId = $(this).data("course-id");

                Swal.fire({
                    title: "Assign Teacher",
                    html: `
                    <select id="teacher_id" class="swal2-input">
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                `,
                    showCancelButton: true,
                    confirmButtonText: "Assign",
                    preConfirm: () => {
                        return {
                            course_id: courseId,
                            teacher_id: $("#teacher_id").val()
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('course.assignTeacher') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                course_id: result.value.course_id,
                                teacher_id: result.value.teacher_id
                            },
                            success: function() {
                                Swal.fire("Success", "Teacher assigned successfully!",
                                    "success");
                                location.reload();
                            },
                            error: function() {
                                Swal.fire("Error", "Something went wrong!", "error");
                            }
                        });
                    }
                });
            });

        });

        function updatePathOfPath() {
            let selectedPath = $("#course_path_id option:selected");
            let pathOfPathDropdown = $("#path_of_path_id");
            let paths = selectedPath.data("paths"); // Get paths from selected option

            // Clear and add default option
            pathOfPathDropdown.empty().append(`<option value="">Select Path of Path</option>`);

            if (paths) {
                paths.forEach((path) => {
                    pathOfPathDropdown.append(`<option value="${path.id}">${path.name}</option>`);
                });
            }
        }
    </script>

</body>

</html>
