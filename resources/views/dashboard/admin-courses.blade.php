<!doctype html>
<html class="no-js" lang="zxx">
@include('include.head')

<body class="body__wrapper">

    @include('include.load')
    @include('include.preload')
    <main class="main_wrapper overflow-hidden">

        <!-- headar section start -->
        @include('include.dash-nav')

        <!-- headar section end -->
        <!-- theme fixed shadow -->
        <div>
            <div class="theme__shadow__circle"></div>
            <div class="theme__shadow__circle shadow__right"></div>
        </div>
        <!-- theme fixed shadow -->

        <!-- dashboardarea__menu__start   -->
        <div class="dashboardarea ">
            <div class="container-fluid full__width__padding">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="dashboardarea__wraper">
                            <div class="dashboardarea__img">
                                <div class="dashboardarea__inner admin__dashboard__inner">
                                    <div class="dashboardarea__left">
                                        <div class="dashboardarea__left__img">
                                            <img loading="lazy" src="{{asset('img/dashbord/dashbord__2.jpg')}}" alt="">
                                        </div>
                                        <div class="dashboardarea__left__content">
                                            <h5>Hello</h5>
                                            <h4>{{ Auth::guard('admin')->user()->name ?? 'Admin' }}
                                            </h4>
                                        </div>
                                    </div>
                                    {{-- <div class="dashboardarea__star">
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <i class="icofont-star"></i>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="feather feather-star">
                                        <polygon
                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                        </polygon>
                                    </svg>
                                    <span>4.0 (120 Reviews)</span>
                                </div> --}}
                                    <div class="dashboardarea__right">
                                        <div class="dashboardarea__right__button">
                                            <a class="default__button" href="/create-course">Create a New Course
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-arrow-right">
                                                    <line x1="5" y1="12" x2="19" y2="12">
                                                    </line>
                                                    <polyline points="12 5 19 12 12 19"></polyline>
                                                </svg></a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard">
                <div class="container-fluid full__width__padding">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-12">
                            <div class="dashboard__inner sticky-top">
                                
    @include('include.admin-sidebar')
                                

                                {{-- <div class="dashboard__nav__title mt-40">
                                    <h6>user</h6>
                                </div>

                                <div class="dashboard__nav">
                                    <ul>
                                        <li>
                                            <a href="admin-settings.html">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-settings">
                                                    <circle cx="12" cy="12" r="3"></circle>
                                                    <path
                                                        d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                                                    </path>
                                                </svg>
                                                Settings</a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-volume-1">
                                                    <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                                                    <path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                                                </svg>
                                                Logout</a>
                                        </li>



                                    </ul>
                                </div> --}}


                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-12">
                            <div class="dashboard__content__wraper">
                                <!-- Course Status Title -->
                                <div class="dashboard__section__title">
                                    <h4>Courses</h4>
                                </div>

                                <!-- Courses Content -->
                                <div class="row">
                                    <div class="col-xl-12 aos-init aos-animate" data-aos="fade-up">
                                        <ul class="nav about__button__wrap dashboard__button__wrap" id="myTab"
                                            role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="single__tab__link active" data-bs-toggle="tab"
                                                    data-bs-target="#projects__one" type="button"
                                                    aria-selected="true" role="tab">Courses</button>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="tab-content tab__content__wrapper aos-init aos-animate"
                                        id="myTabContent" data-aos="fade-up">
                                        <div class="tab-pane fade show active" id="projects__one" role="tabpanel">
                                            <div class="row">
                                                @foreach ($courses as $course)
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                                        <div class="gridarea__wraper">
                                                            <div class="gridarea__img">
                                                                <a href="/session-details">
                                                                    <img loading="lazy" src="{{asset('img/grid/grid_1.png')}}"
                                                                        alt="grid">
                                                                </a>
                                                                <div class="gridarea__small__button">
                                                                    <div class="grid__badge">{{ $course->slug }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="gridarea__content">
                                                                <div class="gridarea__list">
                                                                    <ul>
                                                                        <li>
                                                                            <i class="icofont-book-alt"></i>
                                                                            {{ $course->totalLessonsCount() }} Lessons
                                                                        </li>
                                                                        <li>
                                                                            <i class="icofont-clock-time"></i>
                                                                            ~{{ ($course->totalLessonsCount() * 30) / 60 }}
                                                                            Hours
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="gridarea__heading">
                                                                    <h3><a
                                                                            href="{{ route('instructor.course_details', $course->id) }}">{{ $course->name }}</a>
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>

                <!-- dashboardarea__menu__end   -->

                <!-- footer__section__start -->
                @include('include.dash-footer')
@include('include.scripts')
                <!-- footer__section__end -->






    </main>


    <!-- JS here -->
    <script src="../js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="../js/vendor/jquery-3.6.0.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/isotope.pkgd.min.js"></script>
    <script src="../js/slick.min.js"></script>
    <script src="../js/jquery.meanmenu.min.js"></script>
    <script src="../js/ajax-form.js"></script>
    <script src="../js/wow.min.js"></script>
    <script src="../js/jquery.scrollUp.min.js"></script>
    <script src="../js/imagesloaded.pkgd.min.js"></script>
    <script src="../js/jquery.magnific-popup.min.js"></script>
    <script src="../js/waypoints.min.js"></script>
    <script src="../js/jquery.counterup.min.js"></script>
    <script src="../js/plugins.js"></script>
    <script src="../js/swiper-bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
    <script src="../js/main.js"></script>

    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem("theme-color") === "dark" || (!("theme-color" in localStorage) && window.matchMedia(
                "(prefers-color-scheme: dark)").matches)) {
            document.getElementById("light--to-dark-button")?.classList.add("dark--mode");
        }
        if (localStorage.getItem("theme-color") === "light") {
            document.getElementById("light--to-dark-button")?.classList.remove("dark--mode");
        }
    </script>


</body>

</html>
