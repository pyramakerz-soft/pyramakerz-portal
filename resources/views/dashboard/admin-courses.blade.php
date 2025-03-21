<!doctype html>
<html class="no-js" lang="zxx">
@include('include.head')

<body class="body__wrapper">

    @include('include.load')
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
            @include('include.admin-topbar')

            {{-- <div class="dashboard"> --}}
                <div class="container-fluid full__width__padding">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-12">
                            

                                @include('include.sidebar')

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
                                                    data-bs-target="#projects__one" type="button" aria-selected="true"
                                                    role="tab">Courses</button>
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
                                                                <a href="{{ route('instructor.course_details', $course->id) }}">
                                                                    <img loading="lazy"
                                                                        src="{{ $course->image ? asset($course->image) : asset('img/course.jpg') }}"
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
                {{-- </div> --}}

                <!-- dashboardarea__menu__end   -->

                <!-- footer__section__start -->
                
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
