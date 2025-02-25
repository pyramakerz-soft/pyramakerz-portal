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
            @include('include.admin-topbar')
            <div class="dashboard">
                <div class="container-fluid full__width__padding">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-12">
                            @include('include.inst-sidebar')

                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-12">
                            <div class="dashboard__content__wraper">
                                <div class="dashboard__section__title">
                                    <h4>My Profile</h4>
                                </div>
                                <div class="row">
                                    <div class="col-xl-12 aos-init aos-animate" data-aos="fade-up">
                                        <ul class="nav  about__button__wrap dashboard__button__wrap" id="myTab"
                                            role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="single__tab__link active" data-bs-toggle="tab"
                                                    data-bs-target="#projects__one" type="button" aria-selected="true"
                                                    role="tab">Profile</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="single__tab__link" data-bs-toggle="tab"
                                                    data-bs-target="#projects__two" type="button" aria-selected="false"
                                                    role="tab" tabindex="-1">Password</button>
                                            </li>



                                        </ul>
                                    </div>


                                    <div class="tab-content tab__content__wrapper aos-init aos-animate"
                                        id="myTabContent" data-aos="fade-up">

                                        <div class="tab-pane fade active show" id="projects__one" role="tabpanel"
                                            aria-labelledby="projects__one">
                                            <div class="row">
                                                <div class="col-xl-12">

                                                    <!-- <div class="dashboardarea__wraper">
                                                    <div class="dashboardarea__img dashboardarea__margin__0">
                                                        <div class="dashboardarea__inner student__dashboard__inner">
                                                            <div class="dashboardarea__left">
                                                                <div class="dashboardarea__left__img">
                                                                    <img loading="lazy"  src="../img/teacher/teacher__2.png" alt="">
                                                                </div>
                                                                <div class="dashboardarea__left__content">
                                                                    <h4>Dond Tond</h4>
                                                                    <ul>
                                                                        <li>                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                                                                        9 Courses Enroled
                                                                        </li>
                                                                        <li>
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-award"><circle cx="12" cy="8" r="7"></circle><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"></polyline></svg>
                                                                            8 Certificate
                                                                        </li>
                                                                    </ul>
                        
                                                                </div>
                                                            </div>
                                                            <div class="dashboardarea__right">
                                                                <div class="dashboardarea__right__button">
                                                                    <a class="default__button" href="create-course.html">Enroll A New Course
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></a>
                                                                </div>
                                                            </div>
                        
                                                        </div>
                                                    </div>
                                                </div> -->

                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="dashboard__form__wraper">
                                                                <div class="dashboard__form__input">
                                                                    <label for="#">First Name</label>
                                                                    <input type="text" placeholder="first Name">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6">
                                                            <div class="dashboard__form__wraper">
                                                                <div class="dashboard__form__input">
                                                                    <label for="#">Last Name</label>
                                                                    <input type="text" placeholder="Last Name">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6">
                                                            <div class="dashboard__form__wraper">
                                                                <div class="dashboard__form__input">
                                                                    <label for="#">User Name</label>
                                                                    <input type="text" placeholder="UserName">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6">
                                                            <div class="dashboard__form__wraper">
                                                                <div class="dashboard__form__input">
                                                                    <label for="#">Phone Number</label>
                                                                    <input type="text"
                                                                        placeholder="+1-202-555-0174">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6">
                                                            <div class="dashboard__form__wraper">
                                                                <div class="dashboard__form__input">
                                                                    <label for="#">Email</label>
                                                                    <input type="email" placeholder="email">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6">
                                                            <div class="dashboard__form__wraper">
                                                                <div class="dashboard__form__input">
                                                                    <label for="#">Profile picture</label>
                                                                    <input type="file" id="myFile"
                                                                        name="filename">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-12">
                                                            <div class="dashboard__form__button">
                                                                <a class="default__button" href="#">Update
                                                                    Info</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="tab-pane fade" id="projects__two" role="tabpanel"
                                            aria-labelledby="projects__two">

                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="dashboard__form__wraper">
                                                        <div class="dashboard__form__input">
                                                            <label for="#">Current Password</label>
                                                            <input type="text" placeholder="Current password">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-12">
                                                    <div class="dashboard__form__wraper">
                                                        <div class="dashboard__form__input">
                                                            <label for="#">New Password</label>
                                                            <input type="text" placeholder="New Password">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-12">
                                                    <div class="dashboard__form__wraper">
                                                        <div class="dashboard__form__input">
                                                            <label for="#">Re-Type New Password</label>
                                                            <input type="text" placeholder="Re-Type New Password">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="dashboard__form__button">
                                                        <a class="default__button" href="#">Update Password</a>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>







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
