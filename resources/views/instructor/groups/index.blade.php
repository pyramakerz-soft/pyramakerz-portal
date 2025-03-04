<!doctype html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')
    <script src="{{ asset('js/vendor/jquery-3.6.0.min.js') }}"></script> <!-- Ensure jQuery loads first -->
</head>


<body class="body__wrapper">
    @include('include.load')


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
                    <div class="col-xl-8" data-aos="fade-up">
                        <div class="breadcrumb__content__wraper">
                            <div class="breadcrumb__inner text-start">
                                <ul>
                                    <li><a href="/">Home</a></li>
                                    <li><a
                                            href="{{ route('instructor.course_details', $course->id) }}">{{ $course->name }}</a>
                                    </li>
                                    <li>Groups</li>
                                </ul>
                            </div>
                        </div>

                        <div class="course__details__top--2">
                            <div class="course__details__heading">
                                <h3>Groups for {{ $course->name }}</h3>
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
                            <div class="course__details__tab__wrapper">
                                <div class="experence__heading">
                                    <h5>List of Groups</h5>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Group Name</th>
                                                <th>Students</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($course->groups->count() > 0)
                                                @if (Auth::guard('admin')->user()->roles[0]->name == 'instructor')
                                                    @foreach ($course->groups->where('instructor_id', Auth::guard('admin')->user()->id) as $group)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $group->name }}</td>
                                                            <td>{{ isset($group->students) ? $group->students->count() : 0 }}
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('instructor.group_details', $group->id) }}"
                                                                    class="btn btn-sm btn-black">
                                                                    <i class="icofont-eye"></i> View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    @foreach ($course->groups as $group)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $group->name }}</td>
                                                            <td>{{ isset($group->students) ? $group->students->count() : 0 }}
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('instructor.group_details', $group->id) }}"
                                                                    class="btn btn-sm btn-black">
                                                                    <i class="icofont-eye"></i> View
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            @else
                                                <tr>
                                                    <td colspan="4" class="text-center">No groups found for this
                                                        course.</td>
                                                </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Add New Group Button -->
                            @if (Auth::guard('admin')->user()->can('group-create'))
                                <button class="btn default__button mt-3 add-group-btn">
                                    <i class="icofont-plus"></i> Add New Group
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-xl-3 col-lg-3" data-aos="fade-up">
                        <div class="course__details__sidebar--2">
                            <div class="event__sidebar__wraper">
                                <div class="blogarae__img__2 course__details__img__2">
                                    <img loading="lazy"
                                        src="{{ $course->image ? asset($course->image) : asset('img/course.jpg') }}"
                                        alt="Course">
                                </div>

                                <div class="course__summery__button">
                                    <a class="default__button"
                                        href="{{ route('instructor.course_details', $course->id) }}">
                                        <i class="icofont-arrow-left"></i> Back to Course
                                    </a>
                                </div>

                                <div class="course__summery__lists">
                                    <ul>
                                        <li>
                                            <div class="course__summery__item">
                                                <span class="sb_label">Total Groups:</span>
                                                <span class="sb_content">{{ $course->groups->count() ?? 0 }}</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="course__summery__item">
                                                <span class="sb_label">Total Students:</span>
                                                <span
                                                    class="sb_content">{{ isset($group) ? $group->students->count() : 0 }}</span>

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
        @include('include.scripts')
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
            $(".add-group-btn").click(function() {
                Swal.fire({
                    title: "Create New Group",
                    html: `
            <div style=" text-align: left; display: flex; flex-direction: column; gap: 10px;">
                <label style="font-weight: 600;">Group Name</label>
                <input type="text" id="group_name" class="swal2-input" placeholder="Enter group name">
             
                <label style="font-weight: 600;">Assign Instructor</label>
                <select id="instructor_id" class="swal2-input" style=" width:80%; margin: 0 auto; ">
                    <option value="">Select Instructor</option>
                    @foreach ($instructors as $instructor)
                        <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                    @endforeach
                    </select>

                <label style="font-weight: 600;">Number of Weekly Sessions</label>
                <input type="number" id="weekly_sessions" class="swal2-input" min="1" max="7" placeholder="Sessions per week" oninput="generateSessionDays()">

                <div class="row "  style="padding-bottom:5px; width:80%; margin:0 auto;" id="session_days_container"></div> <!-- Session Days Dropdowns -->

                <label style="font-weight: 600;">Start Date</label>
                <input type="text" id="start_date" class="swal2-input" placeholder="Select start date" readonly>

                <label style="font-weight: 600;">Start Time</label>
                <input type="time" id="start_time" class="swal2-input">

                <label style="font-weight: 600;">End Time</label>
                <input type="time" id="end_time" class="swal2-input">
            </div>
        `,

                    didOpen: () => {
                        flatpickr("#start_date", {
                            dateFormat: "Y-m-d"
                        });
                    },
                    showCancelButton: true,
                    confirmButtonText: "Save",
                    confirmButtonColor: '#ff7918',
                    preConfirm: () => {
                        let groupName = $("#group_name").val();
                        let instructorId = $("#instructor_id").val();
                        let weeklySessions = $("#weekly_sessions").val();
                        let startDate = $("#start_date").val();
                        let startTime = $("#start_time").val();
                        let endTime = $("#end_time").val();

                        let selectedDays = [];
                        $(".session_day").each(function() {
                            selectedDays.push($(this).val());
                        });

                        if (!groupName || !weeklySessions || !startDate || !startTime || !
                            endTime || selectedDays.length !== parseInt(weeklySessions)) {
                            Swal.showValidationMessage("All fields are required!");
                            return false;
                        }

                        return {
                            name: groupName,
                            instructor_id: instructorId,
                            weekly_sessions: weeklySessions,
                            start_date: startDate,
                            start_time: startTime,
                            end_time: endTime,
                            session_days: selectedDays,
                            course_id: {{ $course->id }}
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('instructor.create_group') }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                name: result.value.name,
                                instructor_id: result.value.instructor_id,
                                weekly_sessions: result.value.weekly_sessions,
                                start_date: result.value.start_date,
                                start_time: result.value.start_time,
                                end_time: result.value.end_time,
                                session_days: result.value.session_days,
                                course_id: result.value.course_id
                            },
                            success: function() {
                                Swal.fire({
                                    title: "Success",
                                    text: "Group created successfully!",
                                    icon: "success",
                                    confirmButtonText: "OK",
                                    confirmButtonColor: '#ff7918',
                                });
                                setTimeout(() => {
                                    window.location.href = window.location.href;
                                }, 1000);
                            },
                            error: function(xhr) {
                                let errorMessage = "Something went wrong!";
                                if (xhr.responseJSON && xhr.responseJSON.message) {
                                    errorMessage = xhr.responseJSON.message;
                                }
                                Swal.fire({
                                    icon: "Error",
                                    text: errorMessage,
                                    title: "error",
                                    confirmButtonColor: '#ff7918',
                                });
                            }
                        });
                    }
                });
            });




        });
        // Function to generate session day dropdowns dynamically
        function generateSessionDays() {
            let container = $("#session_days_container");
            container.empty();
            let numSessions = parseInt($("#weekly_sessions").val());

            if (numSessions > 0 && numSessions <= 7) {
                let daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
                for (let i = 0; i < numSessions; i++) {
                    let selectHTML = `
                <label style="font-weight: 600;">Session ${i + 1} Day</label>
                <select class="swal2-input session_day" style="border-radius: 8px;">
                    <option value="">Select Day</option>
                    ${daysOfWeek.map(day => `<option value="${day}">${day}</option>`).join('')}
                </select>
            `;
                    container.append(selectHTML);
                }
            }
        }
    </script>
</body>

</html>
