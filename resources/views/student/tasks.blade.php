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
                                    <h4>Assignment</h4>
                                </div>


                                <hr class="mt-40">
                                <div class="row">

                                    <div class="col-xl-12">
                                        <div class="dashboard__table table-responsive">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Assignment Name</th>
                                                        <th>Total Marks</th>
                                                        <th>Total Submit</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>

                                                            <span>Task Name</span>
                                                            <p>course: <a href="#">AI Track</a></p>
                                                        </th>
                                                        <td>
                                                            <p>80</p>
                                                        </td>
                                                        <td>
                                                            <p>2</p>
                                                        </td>


                                                        <td>
                                                            <div class="dashboard__button__group">

                                                                <a class="dashboard__small__btn__2" href="#">
                                                                    <i class="icofont-edit"></i>Edit
                                                                </a>
                                                                <a class="dashboard__small__btn__2 dashboard__small__btn__3"
                                                                    href="#">
                                                                    <i class="icofont-paper-plane"></i> Submit
                                                                </a>

                                                                <a class="dashboard__small__btn__2" href="#">
                                                                    <i class="icofont-download"></i> Download
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr class="dashboard__table__row">
                                                        <th>

                                                            <span>Task Name</span>
                                                            <p>course: <a href="#">AI Track</a></p>
                                                        </th>
                                                        <td>
                                                            <p>80</p>
                                                        </td>
                                                        <td>
                                                            <p>2</p>
                                                        </td>


                                                        <td>
                                                            <div class="dashboard__button__group">

                                                                <a class="dashboard__small__btn__2" href="#">
                                                                    <i class="icofont-edit"></i>Edit
                                                                </a>
                                                                <a class="dashboard__small__btn__2 dashboard__small__btn__3"
                                                                    href="#">
                                                                    <i class="icofont-paper-plane"></i> Submit
                                                                </a>

                                                                <a class="dashboard__small__btn__2" href="#">
                                                                    <i class="icofont-download"></i> Download
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>

                                                            <span>Task Name</span>
                                                            <p>course: <a href="#">AI Track</a></p>
                                                        </th>
                                                        <td>
                                                            <p>80</p>
                                                        </td>
                                                        <td>
                                                            <p>2</p>
                                                        </td>



                                                        <td>
                                                            <div class="dashboard__button__group">

                                                                <a class="dashboard__small__btn__2" href="#">
                                                                    <i class="icofont-edit"></i>Edit
                                                                </a>
                                                                <a class="dashboard__small__btn__2 dashboard__small__btn__3"
                                                                    href="#">
                                                                    <i class="icofont-paper-plane"></i> Submit
                                                                </a>

                                                                <a class="dashboard__small__btn__2" href="#">
                                                                    <i class="icofont-download"></i> Download
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr class="dashboard__table__row">
                                                        <th>

                                                            <span>Task Name</span>
                                                            <p>course: <a href="#">AI Track</a></p>
                                                        </th>
                                                        <td>
                                                            <p>80</p>
                                                        </td>
                                                        <td>
                                                            <p>2</p>
                                                        </td>


                                                        <td>
                                                            <div class="dashboard__button__group">

                                                                <a class="dashboard__small__btn__2" href="#">
                                                                    <i class="icofont-edit"></i>Edit
                                                                </a>
                                                                <a class="dashboard__small__btn__2 dashboard__small__btn__3"
                                                                    href="#">
                                                                    <i class="icofont-paper-plane"></i> Submit
                                                                </a>

                                                                <a class="dashboard__small__btn__2" href="#">
                                                                    <i class="icofont-download"></i> Download
                                                                </a>
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
