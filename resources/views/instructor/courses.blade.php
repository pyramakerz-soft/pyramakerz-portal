<!doctype html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')
</head>

<body class="body__wrapper">

    @include('include.load')
    @include('include.preload')

    <main class="main_wrapper overflow-hidden">

        @include('include.nav')

        <!-- theme fixed shadow -->
        <div>
            <div class="theme__shadow__circle"></div>
            <div class="theme__shadow__circle shadow__right"></div>
        </div>
        <!-- theme fixed shadow -->

        <!-- dashboardarea__area__start  -->
        <div class="dashboardarea sp_bottom_100">
            @include('include.stud-topbar')

            <div class="dashboard">
                <div class="container-fluid full__width__padding">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-12">
                            @include('include.inst-sidebar')
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-12">
                            <div class="dashboard__content__wraper">
                                <div class="dashboard__section__title">
                                    <h4>My Courses</h4>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 aos-init aos-animate" data-aos="fade-up">
                                        <ul class="nav about__button__wrap dashboard__button__wrap" id="myTab"
                                            role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="single__tab__link " data-bs-toggle="tab"
                                                    data-bs-target="#projects__one" type="button" aria-selected="false"
                                                    role="tab">Finished Courses</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="single__tab__link active" data-bs-toggle="tab"
                                                    data-bs-target="#projects__two" type="button" aria-selected="true"
                                                    role="tab">Active Courses</button>
                                            </li>
                                            {{-- <li class="nav-item" role="presentation">
                                                <button class="single__tab__link" data-bs-toggle="tab"
                                                    data-bs-target="#projects__three" type="button"
                                                    aria-selected="false" role="tab">Upcoming Courses</button>
                                            </li> --}}
                                        </ul>
                                    </div>

                                    <div class="tab-content tab__content__wrapper aos-init aos-animate"
                                        id="myTabContent" data-aos="fade-up">

                                        <!-- Enrolled Courses -->
                                        @foreach ($courses as $course)
                                            <div class="tab-pane fade show" id="projects__one" role="tabpanel">
                                                <div class="row">
                                                    <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                                        <div class="gridarea__wraper">
                                                            <div class="gridarea__img">
                                                                <a href="/session-details">
                                                                    <img loading="lazy" src="{{asset('img/grid/grid_1.png')}}"
                                                                        alt="grid">
                                                                </a>
                                                                <div class="gridarea__small__button">
                                                                    <div class="grid__badge">{{ $course->course->slug }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="gridarea__content">
                                                                <div class="gridarea__list">
                                                                    <ul>
                                                                        <li>
                                                                            <i class="icofont-book-alt"></i>
                                                                            {{ $course->course->totalLessonsCount() }}
                                                                            Lessons
                                                                        </li>
                                                                        <li>
                                                                            <i class="icofont-clock-time"></i>
                                                                            ~{{ ($course->course->totalLessonsCount() * 30) / 60 }}
                                                                            Hours
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="gridarea__heading">
                                                                    <h3><a
                                                                            href="/session-details">{{ $course->course->name }}</a>
                                                                    </h3>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        <!-- Active Courses -->
                                        <div class="tab-pane active fade" id="projects__two" role="tabpanel">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                                    <div class="gridarea__wraper">
                                                        <div class="gridarea__img">
                                                            <img loading="lazy" src="{{asset('img/grid/grid_2.png')}}"
                                                                alt="grid">
                                                            <div class="gridarea__small__button">
                                                                <div class="grid__badge blue__color">Mechanical</div>
                                                            </div>
                                                        </div>
                                                        <div class="gridarea__content">
                                                            <div class="gridarea__list">
                                                                <ul>
                                                                    <li>
                                                                        <i class="icofont-book-alt"></i> 29 Lessons
                                                                    </li>
                                                                    <li>
                                                                        <i class="icofont-clock-time"></i> 2 hr 10 min
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="gridarea__heading">
                                                                <h3><a href="session-details">Understanding Mechanical
                                                                        Basics</a></h3>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Completed Courses -->
                                        {{-- <div class="tab-pane fade" id="projects__three" role="tabpanel">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-6 col-md-6 col-12">
                                                    <div class="gridarea__wraper">
                                                        <div class="gridarea__img">
                                                            <a href="../course-details.html">
                                                                <img loading="lazy" src="../img/grid/grid_3.png"
                                                                    alt="grid">
                                                            </a>
                                                            <div class="gridarea__small__button">
                                                                <div class="grid__badge blue__color">Development</div>
                                                            </div>
                                                        </div>
                                                        <div class="gridarea__content">
                                                            <div class="gridarea__list">
                                                                <ul>
                                                                    <li>
                                                                        <i class="icofont-book-alt"></i> 25 Lessons
                                                                    </li>
                                                                    <li>
                                                                        <i class="icofont-clock-time"></i> 1 hr 40 min
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="gridarea__heading">
                                                                <h3><a href="../course-details.html">Completed Course on
                                                                        Development</a></h3>
                                                            </div>
                                                            <div class="gridarea__price">
                                                                $40.00 <del>/ $67.00</del>
                                                                <span> <del class="del__2">Free</del></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> --}}

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
        @include('include.footer')
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
    <script src="../js/main.js"></script>

</body>

</html>
