<!doctype html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')
</head>

<body class="body__wrapper">
    @include('include.load')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                            </div>
                            <div class="course__details__price" data-aos="fade-up">
                                <ul>
                                    <li>
                                        <div class="course__details__date">
                                            <i class="icofont-book-alt"></i>
                                            {{ $course->totalLessonsCount() }} Lessons
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
                                    <div class="tab-pane fade active show" id="lessons" role="tabpanel">
                                        <div class="accordion content__cirriculum__wrap" id="accordionExample">
                                            @forelse ($course->coursePaths as $path)
                                                <div class="accordion-item roundd">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#path{{ $path->id }}"
                                                            aria-expanded="false"
                                                            aria-controls="path{{ $path->id }}">
                                                            {{ $path->name }}
                                                        </button>
                                                    </h2>
                                                    <div id="path{{ $path->id }}"
                                                        class="accordion-collapse collapse"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <!-- Loop through path_of_paths inside this course path -->
                                                            <div class="accordion"
                                                                id="subPathAccordion{{ $path->id }}">
                                                                @forelse ($path->paths as $subPath)
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header">
                                                                            <button class="accordion-button collapsed"
                                                                                type="button"
                                                                                data-bs-toggle="collapse"
                                                                                data-bs-target="#subPath{{ $subPath->id }}"
                                                                                aria-expanded="false"
                                                                                aria-controls="subPath{{ $subPath->id }}">
                                                                                {{ $subPath->name }}
                                                                            </button>
                                                                        </h2>
                                                                        <div id="subPath{{ $subPath->id }}"
                                                                            class="accordion-collapse collapse"
                                                                            data-bs-parent="#subPathAccordion{{ $path->id }}">
                                                                            <div class="accordion-body">
                                                                                <!-- Nested accordion for lessons -->
                                                                                <div class="accordion"
                                                                                    id="lessonAccordion{{ $subPath->id }}">
                                                                                    @forelse ($subPath->lessons->sortBy('order') as $lesson)
                                                                                        <div class="accordion-item">
                                                                                            <h2
                                                                                                class="accordion-header">
                                                                                                <button
                                                                                                    class="accordion-button collapsed"
                                                                                                    type="button"
                                                                                                    data-bs-toggle="collapse"
                                                                                                    data-bs-target="#lesson{{ $lesson->id }}"
                                                                                                    aria-expanded="false"
                                                                                                    aria-controls="lesson{{ $lesson->id }}">
                                                                                                    {{ $lesson->title }}
                                                                                                    <span>Order:
                                                                                                        {{ $lesson->order ?? 'N/A' }}</span>
                                                                                                </button>
                                                                                            </h2>
                                                                                            <div id="lesson{{ $lesson->id }}"
                                                                                                class="accordion-collapse collapse"
                                                                                                data-bs-parent="#lessonAccordion{{ $subPath->id }}">
                                                                                                <div
                                                                                                    class="accordion-body">
                                                                                                    <!-- Lesson Video -->
                                                                                                    <div
                                                                                                        class="video-container mb-3">
                                                                                                        @if ($lesson->video_url)
                                                                                                            @php
                                                                                                                $isGoogleDrive = str_contains(
                                                                                                                    $lesson->video_url,
                                                                                                                    'drive.google.com',
                                                                                                                );
                                                                                                                $embedUrl = $isGoogleDrive
                                                                                                                    ? preg_replace(
                                                                                                                        '/\/view\?usp=sharing$/',
                                                                                                                        '/preview',
                                                                                                                        $lesson->video_url,
                                                                                                                    )
                                                                                                                    : $lesson->video_url;
                                                                                                            @endphp
                                                                                                            <iframe
                                                                                                                src="{{ $embedUrl }}"
                                                                                                                width="100%"
                                                                                                                height="400"
                                                                                                                frameborder="0"
                                                                                                                allowfullscreen></iframe>
                                                                                                        @else
                                                                                                            <p>No video
                                                                                                                available
                                                                                                                for this
                                                                                                                lesson.
                                                                                                            </p>
                                                                                                        @endif
                                                                                                    </div>
                                                                                                    <p><strong>Description:</strong>
                                                                                                        {{ $lesson->description ?? 'No description available.' }}
                                                                                                    </p>
                                                                                                    @if ($lesson->resource_file)
                                                                                                        <a href="{{ asset($lesson->resource_file) }}"
                                                                                                            download>Download
                                                                                                            Resource</a>
                                                                                                    @else
                                                                                                        <p>No resources
                                                                                                            available
                                                                                                            for this
                                                                                                            lesson.</p>
                                                                                                    @endif
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    @empty
                                                                                        <p>No lessons available in this
                                                                                            sub-path.</p>
                                                                                    @endforelse
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @empty
                                                                    <p>No sub-paths available in this course path.</p>
                                                                @endforelse
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @empty
                                                <p>No course paths available for this course.</p>
                                            @endforelse
                                        </div>
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
                    @if (session('error'))
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: '{{ session('error') }}'
                            });
                        </script>
                    @endif
                    @if (session('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: '{{ session('success') }}'
                            });
                        </script>
                    @endif
                    <!-- Sidebar -->
                    <div class="col-xl-4 col-lg-4">
                        <div class="course__details__sidebar--2">
                            <div class="event__sidebar__wraper" data-aos="fade-up">
                                <div class="blogarae__img__2 course__details__img__2" data-aos="fade-up">
                                    <img loading="lazy"
                                        src="{{ $course->image ? asset($course->image) : asset('img/course.jpg') }}"
                                        alt="blog">
                                </div>

                                <div class="course__summery__button">
                                    @php
                                        $enrollment = \App\Models\StudentEnrollment::where(
                                            'student_id',
                                            Auth::guard('student')->user()->id,
                                        )
                                            ->where('course_id', $course->id)
                                            ->first();
                                    @endphp
                                    @if ($enrollment)
                                        @if ($enrollment->status == 'pending')
                                            <a class="default__button disable"
                                                href="{{ route('student.enroll-now', $course->id) }}">Pending
                                                Course</a>
                                        @elseif($enrollment->status == 'enrolled')
                                            <a class="default__button"
                                                href="{{ route('course_lessons', $course->id) }}">Go to Course</a>
                                        @elseif($enrollment->status == 'completed')
                                            <a class="default__button"
                                                href="{{ route('course_lessons', $course->id) }}">Course Completed</a>
                                        @endif
                                    @else
                                        <a class="default__button"
                                            href="{{ route('student.enroll-now', $course->id) }}">Enroll Now</a>
                                    @endif
                                </div>

                                <div class="course__summery__lists">
                                    <ul>
                                        <li>
                                            <div class="course__summery__item">
                                                <span class="sb_label">Instructor:</span>
                                                <span class="sb_content"><a href="#">Eng. Ashraf</a></span>
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
</body>

</html>
