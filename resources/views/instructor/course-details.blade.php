<!doctype html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')
</head>

<body class="body__wrapper">
    @include('include.load')


    <main class="main_wrapper overflow-hidden">
        @include('include.nav')

        <div>
            <div class="theme__shadow__circle"></div>
            <div class="theme__shadow__circle shadow__right"></div>
        </div>

        <!-- breadcrumbarea__section__start -->
        <div class="breadcrumbarea breadcrumbarea--2">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="breadcrumb__content__wraper" data-aos="fade-up">
                            <div class="breadcrumb__inner text-start">
                                <ul>
                                    <li><a href="{{route('courses.all')}}">Home</a></li>
                                    <li>{{ $course->name ?? 'Course Details' }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="course__details__top--2">
                            <div class="course__details__heading" data-aos="fade-up">
                                <h3>{{ $course->name ?? 'Course Title' }}</h3>

                                @if (Auth::guard('admin')->user()->can('group-list'))
                                <a class="btn default__button btn-sm"
                                    href="{{ route('instructor.groups', $course->id) }}">
                                    <i class="icofont-users"></i> View Groups
                                </a>
                                @endif
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




        <div class="blogarea__2 sp_top_80 sp_bottom_100">
            <div class="container-fluid full__width__padding">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-12" data-aos="fade-up">
                        @include('include.sidebar')

                    </div>
                    <div class="col-xl-6 col-lg-6" data-aos="fade-up">
                        <div class="blog__details__content__wraper">
                            <div class="course__details__tab__wrapper" data-aos="fade-up">
                                <div class="tab-content tab__content__wrapper" id="myTabContent">
                                    <!-- Lessons Tab -->
                                    <div class="tab-pane fade active show" id="lessons" role="tabpanel">
                                        <div class="accordion content__cirriculum__wrap" id="accordionExample">
                                            @if (isset($course))
                                            @foreach ($course->coursePaths as $path)
                                            <div class="mb-3">
                                                <h5 class="text-primary">{{ $path->name }}</h5>

                                                @foreach ($path->paths as $pathOfPath)
                                                <div class="accordion mb-3" id="accordionPathOfPath{{ $pathOfPath->id }}">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingPathOfPath{{ $pathOfPath->id }}">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapsePathOfPath{{ $pathOfPath->id }}"
                                                                aria-expanded="false"
                                                                aria-controls="collapsePathOfPath{{ $pathOfPath->id }}">
                                                                {{ $pathOfPath->name }}
                                                            </button>
                                                        </h2>
                                                        <div id="collapsePathOfPath{{ $pathOfPath->id }}"
                                                            class="accordion-collapse collapse"
                                                            aria-labelledby="headingPathOfPath{{ $pathOfPath->id }}"
                                                            data-bs-parent="#accordionPathOfPath{{ $pathOfPath->id }}">
                                                            <div class="accordion-body">

                                                                @foreach ($pathOfPath->lessons as $lesson)
                                                                <div class="accordion" id="accordionLesson{{ $lesson->id }}">
                                                                    <div class="accordion-item roundd">
                                                                        <h2 class="accordion-header">
                                                                            <button class="accordion-button collapsed" type="button"
                                                                                data-bs-toggle="collapse"
                                                                                data-bs-target="#lesson{{ $lesson->id }}"
                                                                                aria-expanded="false"
                                                                                aria-controls="lesson{{ $lesson->id }}">
                                                                                {{ $lesson->title }}
                                                                                <span class="ms-auto">Order: {{ $lesson->order ?? 'N/A' }}</span>

                                                                                @can('lessonresource-create')
                                                                                <i class="icofont-plus-circle add-material-btn ms-2"
                                                                                    data-lesson-id="{{ $lesson->id }}"
                                                                                    title="Add Material"
                                                                                    style="cursor: pointer; font-size: 1.2rem;"></i>
                                                                                @endcan
                                                                            </button>
                                                                        </h2>
                                                                        <div id="lesson{{ $lesson->id }}"
                                                                            class="accordion-collapse collapse"
                                                                            data-bs-parent="#accordionLesson{{ $lesson->id }}">
                                                                            <div class="accordion-body">
                                                                                <p><strong>Description:</strong> {{ $lesson->description ?? 'No description available.' }}</p>

                                                                                @if ($lesson->resources->isNotEmpty())
                                                                                <div class="lesson-resources">
                                                                                    @foreach ($lesson->resources as $resource)
                                                                                    <div class="resource-item mb-2">
                                                                                        <a href="{{ $resource->file_path ? asset($resource->file_path) : $resource->resource_link }}"
                                                                                            target="_blank">
                                                                                            {{ $resource->title ?? basename($resource->file_path) }}
                                                                                        </a>
                                                                                        @if ($resource->title !== 'handout')
                                                                                        <a href="{{ $resource->file_path ? asset($resource->file_path) : $resource->resource_link }}"
                                                                                            download
                                                                                            class="btn btn-sm btn-outline-primary ms-2">
                                                                                            Download
                                                                                        </a>
                                                                                        @endif
                                                                                    </div>
                                                                                    @endforeach
                                                                                </div>
                                                                                @else
                                                                                <p>No resources available for this lesson.</p>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            @endforeach

                                            @endif
                                        </div>

                                        @if (Auth::guard('admin')->user()->can('lesson-create'))
                                        <button
                                            class="btn btn-outline-primary mt-3 add-lesson-btn default__button default__button--3">
                                            <i class="icofont-plus"></i> Add Lesson
                                        </button>
                                        @endif
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
                    <div class="col-xl-3 col-lg-3">
                        <div class="course__details__sidebar--2">
                            <div class="event__sidebar__wraper" data-aos="fade-up">
                                <div class="blogarae__img__2 course__details__img__2" data-aos="fade-up">
                                    <img loading="lazy"
                                        src="{{ $course->image ? asset($course->image) : asset('img/course.jpg') }}"
                                        alt="blog">
                                </div>
                                <div class="course__summery__lists">
                                    {{-- Course name and details --}}
                                    {{-- <div class="course__summery__lists">
                                        <ul>
                                            <li>
                                                <div class="course__summery__item">
                                                    <span class="sb_label">Course Name:</span>
                                                    <span
                                                        class="sb_content
                                                    ">{{ $course->name ?? 'Course Title' }}</span>
                                </div>
                            </div> --}}
                            {{-- <div class="course__summery__lists">
                                    <ul>
                                        <li>
                                            <div class="course__summery__item">
                                                <span class="sb_label">Instructor:</span>
                                                <span class="sb_content">
                                                    @if ($course->instructor)
                                                        {{ $course->instructor->name }}
                            @if (Auth::guard('admin')->user()->can('course-edit') || Auth::guard('admin')->user()->can('course-create'))
                            <button
                                class="btn btn-sm btn-outline-warning assign-teacher-btn"
                                data-course-id="{{ $course->id }}"
                                style="border: none;">
                                Change Instructor
                            </button>
                            @endif
                            @else
                            @if (Auth::guard('admin')->user()->can('course-edit') || Auth::guard('admin')->user()->can('course-create'))
                            <button
                                class="btn btn-sm btn-outline-success assign-teacher-btn"
                                data-course-id="{{ $course->id }}"
                                style="border: none;">
                                + Assign Instructor
                            </button>
                            @endif
                            @endif
                            </span>
                        </div>
                        </li>
                        </ul>
                    </div> --}}
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>

        @include('include.footer')
        @include('include.scripts')
    </main>

    <!-- JS Scripts -->
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
            // Existing choose-date and add lesson code here ...

            $(".add-material-btn").click(function() {
                let lessonId = $(this).data("lesson-id");

                Swal.fire({
                    title: "Upload Materials",
                    width: '70%',
                    html: `
        <style>
            .resource-wrapper {
                border: 1px solid #ddd;
                padding: 15px;
                margin-bottom: 20px;
                border-radius: 10px;
                background-color: #f9f9f9;
            }
            .upload-toggle-section {
                margin-top: 10px;
            }
            .upload-area {
                margin-top: 10px;
            }
            .input-group {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-bottom: 10px;
            }
            .swal2-input {
                margin-bottom: 0 !important;
            }
            .add-more-btn, .remove-btn {
                cursor: pointer;
                color: #007bff;
                font-size: 18px;
                border: none;
                background: none;
            }
            .add-more-btn:hover, .remove-btn:hover {
                color: #ff7918;
            }
        </style>
        <div id="materialTypes">
            ${['session', 'teaching_guide', 'project', 'quiz', 'assignment', 'handout'].map(type => `
                <div class="resource-wrapper">
                    <label>
                        <input type="checkbox" class="resource-type-checkbox" value="${type}"> 
                        <strong>${type.replace('_', ' ').toUpperCase()}</strong>
                    </label>

                    <div class="upload-toggle-section" data-type="${type}" style="display:none;">
                        ${type !== 'handout' ? `
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input upload-toggle" type="checkbox" data-type="${type}" checked>
                            <label class="form-check-label">Upload Files</label>
                        </div>` : ''
                    }

                        <div class="upload-area" data-type="${type}">
                            <!-- Dynamic inputs go here -->
                        </div>
                        <button type="button" class="add-more-btn" data-type="${type}">+ Add More</button>
                    </div>
                </div>
            `).join('')}
        </div>
        `,
                    didOpen: () => {
                        const createInputGroup = (type, isUpload = true) => {
                            const inputId = 'input-' + Date.now() + Math.random().toString(36).substring(2, 7);
                            return `
                    <div class="input-group" data-type="${type}" id="${inputId}">
                        ${isUpload
                            ? `<input type="file" class="swal2-input form-control file-input" data-type="${type}" style="width: 95%">`
                            : `<input type="url" class="swal2-input form-control link-input" data-type="${type}" placeholder="Enter link" style="width: 95%">`
                        }
                        <button type="button" class="remove-btn" data-target="${inputId}" title="Remove">&#x2715;</button>
                    </div>`;
                        };

                        $(".resource-type-checkbox").on("change", function() {
                            const type = $(this).val();
                            const section = $(`.upload-toggle-section[data-type="${type}"]`);
                            const area = $(`.upload-area[data-type="${type}"]`);
                            area.empty();

                            if (this.checked) {
                                section.show();
                                const isUpload = type === 'handout' || $(`.upload-toggle[data-type="${type}"]`).prop("checked");
                                area.append(createInputGroup(type, isUpload));
                            } else {
                                section.hide();
                            }
                        });

                        $(".upload-toggle").on("change", function() {
                            const type = $(this).data("type");
                            const isUpload = $(this).is(":checked");
                            const area = $(`.upload-area[data-type="${type}"]`);
                            area.empty();
                            area.append(createInputGroup(type, isUpload));
                        });

                        $(document).on("click", ".add-more-btn", function() {
                            const type = $(this).data("type");
                            const isUpload = type === 'handout' || $(`.upload-toggle[data-type="${type}"]`).is(":checked");
                            $(`.upload-area[data-type="${type}"]`).append(createInputGroup(type, isUpload));
                        });

                        $(document).on("click", ".remove-btn", function() {
                            const targetId = $(this).data("target");
                            $(`#${targetId}`).remove();
                        });
                    },
                    showCancelButton: true,
                    confirmButtonText: "Upload",
                    preConfirm: () => {
                        const selected = $(".resource-type-checkbox:checked");
                        if (selected.length === 0) {
                            Swal.showValidationMessage("Please select at least one material type");
                            return false;
                        }

                        const data = [];
                        selected.each(function() {
                            const type = $(this).val();
                            const isUpload = type === 'handout' || $(`.upload-toggle[data-type="${type}"]`).is(":checked");

                            if (isUpload) {
                                $(`.file-input[data-type="${type}"]`).each(function() {
                                    if (!this.files.length) return;
                                    for (let file of this.files) {
                                        data.push({
                                            type,
                                            uploadType: 'file',
                                            file
                                        });
                                    }
                                });
                            } else {
                                $(`.link-input[data-type="${type}"]`).each(function() {
                                    const link = $(this).val();
                                    if (link) {
                                        data.push({
                                            type,
                                            uploadType: 'link',
                                            link
                                        });
                                    }
                                });
                            }
                        });

                        if (data.length === 0) {
                            Swal.showValidationMessage("Please provide at least one file or link.");
                            return false;
                        }

                        return {
                            lesson_id: lessonId,
                            resources: data
                        };
                    },
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData();
                        formData.append("_token", "{{ csrf_token() }}");
                        formData.append("lesson_id", result.value.lesson_id);

                        result.value.resources.forEach((item, index) => {
                            formData.append(`resources[${index}][type]`, item.type);
                            formData.append(`resources[${index}][uploadType]`, item.uploadType);
                            if (item.uploadType === 'file') {
                                formData.append(`resources[${index}][file]`, item.file);
                            } else {
                                formData.append(`resources[${index}][link]`, item.link);
                            }
                        });

                        // ✅ Add this loader before sending the AJAX request
                        Swal.fire({
                            title: 'Uploading...',
                            html: 'Please wait while we upload your materials.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: "{{ route('lesson.uploadMaterial') }}",
                            type: "POST",
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: function() {
                                Swal.fire({
                                    title: "Success",
                                    text: "Materials uploaded successfully!",
                                    icon: "success",
                                }).then(() => location.reload());
                            },
                            error: function() {
                                Swal.fire({
                                    title: "Error",
                                    text: "Upload failed!",
                                    icon: "error",
                                    confirmButtonColor: '#ff7918',
                                });
                            },
                        });
                    }

                });
            });




            // Additional code for assigning teacher, choosing date, etc...
        });
        // 🔹 ASSIGN TEACHER / INSTRUCTOR BUTTON
        $(".assign-teacher-btn").click(function() {
            let courseId = $(this).data("course-id");

            Swal.fire({
                title: "Assign Teacher",
                html: `
            <select id="teacher_id" class="swal2-input form-control" style="border-radius: 8px; padding: 8px;">
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
                            Swal.fire("Success", "Teacher assigned successfully!", "success");
                            location.reload();
                        },
                        error: function() {
                            Swal.fire("Error", "Something went wrong!", "error");
                        }
                    });
                }
            });
        });

        // 🔹 ADD LESSON BUTTON
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
                <select id="course_path_id" class="swal2-input form-control"  onchange="updatePathOfPath()" style="border-radius: 8px; padding: 8px;">
                    <option value="">Select Course Path</option>
                    @foreach ($course->coursePaths ?? [] as $path)
                        <option value="{{ $path->id }}" data-paths='@json($path->paths)'>{{ $path->name }}</option>
                    @endforeach
                </select>

                <label style="font-weight: 600;">Path of Path</label>
                <select id="path_of_path_id" class="swal2-input form-control" style="border-radius: 8px; padding: 8px;">
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
                    let order = $("#lesson_order").val();

                    if (order < 1) {
                        Swal.showValidationMessage("Order number must be at least 1");
                        return false; // Prevent the modal from closing
                    }

                    return {
                        title: $("#lesson_title").val(),
                        order: order,
                        video_url: $("#lesson_video").val(),
                        course_path_id: $("#course_path_id").val(),
                        path_of_path_id: $("#path_of_path_id").val(),
                        course_id: "{{ $course->id }}"
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
                            Swal.fire("Success", "Lesson added successfully!", "success");
                            location.reload();
                        },
                        error: function() {
                            Swal.fire("Error", "Something went wrong!", "error");
                        }
                    });
                }
            });
        });

        // Function to update the "Path of Path" dropdown when a course path is selected.
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