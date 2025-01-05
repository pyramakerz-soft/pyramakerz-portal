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



        <!-- dashboardarea__area__start  -->
        <div class="dashboardarea sp_bottom_100">
            @include('include.stud-topbar')
            <div class="dashboard">
                <div class="container-fluid full__width__padding">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-12">
                            @include('include.stud-sidebar')

                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-12">
                            <div class="dashboard__content__wraper">
                                <div class="dashboard__section__title">
                                    <h4>Summery</h4>
                                </div>
                                <div class="row">
                                    <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                        <div class="dashboard__single__counter">
                                            <div class="counterarea__text__wraper">
                                                <div class="counter__img">
                                                    <img loading="lazy" src="../img/counter/counter__1.png"
                                                        alt="counter">
                                                </div>
                                                <div class="counter__content__wraper">
                                                    <div class="counter__number">
                                                        <span class="counter">27</span>+

                                                    </div>
                                                    <p>Enrolled Courses</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                        <div class="dashboard__single__counter">
                                            <div class="counterarea__text__wraper">
                                                <div class="counter__img">
                                                    <img loading="lazy" src="../img/counter/counter__2.png"
                                                        alt="counter">
                                                </div>
                                                <div class="counter__content__wraper">
                                                    <div class="counter__number">
                                                        <span class="counter">08</span>+

                                                    </div>
                                                    <p>Active Courses</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                        <div class="dashboard__single__counter">
                                            <div class="counterarea__text__wraper">
                                                <div class="counter__img">
                                                    <img loading="lazy" src="../img/counter/counter__3.png"
                                                        alt="counter">
                                                </div>
                                                <div class="counter__content__wraper">
                                                    <div class="counter__number">
                                                        <span class="counter">12</span>

                                                    </div>
                                                    <p>Complete Courses</p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dashboard__content__wraper">
                                <div class="dashboard__section__title">
                                    <h4>Feedbacks</h4>
                                    <a href="../course.html">See More...</a>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="dashboard__table table-responsive">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Course Name</th>
                                                        <th>Enrolled</th>
                                                        <th>Rating</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th><a href="#">Javascript</a></th>
                                                        <td>1100</td>
                                                        <td>
                                                            <div class="dashboard__table__star">
                                                                <i class="icofont-star"></i>
                                                                <i class="icofont-star"></i>
                                                                <i class="icofont-star"></i>
                                                                <i class="icofont-star"></i>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="dashboard__table__row">
                                                        <th><a href="#">PHP</a></th>
                                                        <td>700</td>
                                                        <td>
                                                            <div class="dashboard__table__star">
                                                                <i class="icofont-star"></i>
                                                                <i class="icofont-star"></i>
                                                                <i class="icofont-star"></i>
                                                                <i class="icofont-star"></i>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th><a href="#">HTML</a></th>
                                                        <td>1350</td>
                                                        <td>
                                                            <div class="dashboard__table__star">
                                                                <i class="icofont-star"></i>
                                                                <i class="icofont-star"></i>
                                                                <i class="icofont-star"></i>
                                                                <i class="icofont-star"></i>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr class="dashboard__table__row">
                                                        <th><a href="#">Graphic</a></th>
                                                        <td>1266</td>
                                                        <td>
                                                            <div class="dashboard__table__star">
                                                                <i class="icofont-star"></i>
                                                                <i class="icofont-star"></i>
                                                                <i class="icofont-star"></i>
                                                                <i class="icofont-star"></i>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-star">
                                                                    <polygon
                                                                        points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                                                    </polygon>
                                                                </svg>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>
        <!-- dashboardarea__area__end   -->


        <!-- footer__section__start -->
        @include('include.footer')

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
