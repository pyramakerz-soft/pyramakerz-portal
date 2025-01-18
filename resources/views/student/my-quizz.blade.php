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
                                    <h4>My Quiz Attempts</h4>
                                </div>


                                <div class="row">

                                    <div class="col-xl-12">
                                        <div class="dashboard__table table-responsive">
                                            <table>
                                                <thead>
                                                    <tr>
                                                        <th>Quiz</th>
                                                        <th>Qus</th>
                                                        <th>TM</th>
                                                        <th>CA</th>
                                                        <th>Result</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th>
                                                            <p>December 26, 2024</p>
                                                            <span> AI Track Session four</span>

                                                        </th>
                                                        <td>
                                                            <p>4</p>
                                                        </td>
                                                        <td>
                                                            <p>8</p>
                                                        </td>
                                                        <td>
                                                            <p>4</p>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="dashboard__td dashboard__td--cancel">fail</span>
                                                        </td>
                                                        <td>
                                                            <div class="dashboard__button__group">
                                                                <a class="dashboard__small__btn__2"
                                                                    href="https://docs.google.com/forms/d/1L_HoAiwFs-JKJrakAT3bTpa6ZNkvPT6A3vDZvKfj5lo/viewform?edit_requested=true"
                                                                    target="_blank"> <i class="icofont-eye"></i>View</a>
                                                                <a class="dashboard__small__btn__2 dashboard__small__btn__3"
                                                                    href="#">
                                                                    <i class="icofont-file-check"></i> Result</a>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr class="dashboard__table__row">
                                                        <th>
                                                            <p>December 16, 2024</p>
                                                            <span>AI Track Session three </span>

                                                        </th>
                                                        <td>
                                                            <p>4</p>
                                                        </td>
                                                        <td>
                                                            <p>8</p>
                                                        </td>
                                                        <td>
                                                            <p>4</p>
                                                        </td>
                                                        <td>
                                                            <span class="dashboard__td dashboard__td--over">Over</span>
                                                        </td>
                                                        <td>
                                                            <div class="dashboard__button__group">
                                                                <a class="dashboard__small__btn__2" target="_blank"
                                                                    href="https://docs.google.com/forms/d/1ub7oTHj98ZweV3qo2DxdEki69T-M1m-9lZfyzRYN-Gs/viewform?edit_requested=true">
                                                                    <i class="icofont-eye"></i>View</a>
                                                                <a class="dashboard__small__btn__2  dashboard__small__btn__3"
                                                                    href="#">
                                                                    <i class="icofont-file-check"></i> Result</a>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <th>
                                                            <p>December 6, 2024</p>
                                                            <span>AI Track Session two </span>

                                                        </th>
                                                        <td>
                                                            <p>4</p>
                                                        </td>
                                                        <td>
                                                            <p>8</p>
                                                        </td>
                                                        <td>
                                                            <p>4</p>
                                                        </td>
                                                        <td>
                                                            <span class="dashboard__td">Pass</span>
                                                        </td>
                                                        <td>
                                                            <div class="dashboard__button__group">
                                                                <a class="dashboard__small__btn__2"
                                                                    href="https://docs.google.com/forms/d/1ub7oTHj98ZweV3qo2DxdEki69T-M1m-9lZfyzRYN-Gs/viewform?edit_requested=true"
                                                                    target="_blank"> <i class="icofont-eye"></i>View</a>
                                                                <a class="dashboard__small__btn__2  dashboard__small__btn__3"
                                                                    href="#">
                                                                    <i class="icofont-file-check"></i> Result</a>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr class="dashboard__table__row">
                                                        <th>
                                                            <p>November 26, 2024</p>
                                                            <span> AI Track Session one</span>

                                                        </th>
                                                        <td>
                                                            <p>4</p>
                                                        </td>
                                                        <td>
                                                            <p>8</p>
                                                        </td>
                                                        <td>
                                                            <p>4</p>
                                                        </td>
                                                        <td>
                                                            <span
                                                                class="dashboard__td dashboard__td--cancel">fail</span>
                                                        </td>
                                                        <td>
                                                            <div class="dashboard__button__group">
                                                                <a class="dashboard__small__btn__2"
                                                                    href="https://docs.google.com/forms/d/1HJ_zZjZzftvw982EaAETzh1kdGbJwHHeWN9he6Ldoe8/viewform?edit_requested=true"
                                                                    target="_blank"> <i class="icofont-eye"></i>View</a>
                                                                <a class="dashboard__small__btn__2 dashboard__small__btn__3"
                                                                    href="#">
                                                                    <i class="icofont-file-check"></i> Result</a>
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
