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
                                    <h4>My Profile</h4>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">
                                        <div class="dashboard__form">Registration Date</div>
                                    </div>
                                    <div class="col-lg-8 col-md-8">
                                        <div class="dashboard__form">20, January 2024 9:00 PM</div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="dashboard__form dashboard__form__margin">First Name</div>
                                    </div>
                                    <div class="col-lg-8 col-md-8">
                                        <div class="dashboard__form dashboard__form__margin">Michle</div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="dashboard__form dashboard__form__margin">Last Name</div>
                                    </div>
                                    <div class="col-lg-8 col-md-8">
                                        <div class="dashboard__form dashboard__form__margin">Obema</div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="dashboard__form dashboard__form__margin">Username</div>
                                    </div>
                                    <div class="col-lg-8 col-md-8">
                                        <div class="dashboard__form dashboard__form__margin">obema007</div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="dashboard__form dashboard__form__margin">Email</div>
                                    </div>
                                    <div class="col-lg-8 col-md-8">
                                        <div class="dashboard__form dashboard__form__margin">obema@example.com</div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="dashboard__form dashboard__form__margin">Phone Number</div>
                                    </div>
                                    <div class="col-lg-8 col-md-8">
                                        <div class="dashboard__form dashboard__form__margin">+55 669 4456 25987</div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="dashboard__form dashboard__form__margin">Expert</div>
                                    </div>
                                    <div class="col-lg-8 col-md-8">
                                        <div class="dashboard__form dashboard__form__margin">Graphics Design</div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <div class="dashboard__form dashboard__form__margin">Biography</div>
                                    </div>
                                    <div class="col-lg-8 col-md-8">
                                        <div class="dashboard__form dashboard__form__margin">Lorem, ipsum dolor sit amet
                                            consectetur adipisicing elit. Maiores veniam, delectus accusamus nesciunt
                                            laborum repellat laboriosam, deserunt possimus itaque iusto perferendis
                                            voluptatum quaerat cupiditate vitae. Esse aut illum perferendis nulla,
                                            corporis impedit quasi alias est!</div>
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
        @include('footer')
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