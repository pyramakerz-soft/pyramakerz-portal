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
        <!-- breadcrumbarea__section__start -->



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
                            <div class="dashboard__message__content__main">
                                <div
                                    class="dashboard__message__content__main__title dashboard__message__content__main__title__2">
                                    <h3>Messages</h3>

                                </div>
                                <div class="dashboard__meessage__wraper">
                                    <div class="row">
                                        <div class="col-xl-5 col-lg-6 col-md-12 col-12">
                                            <div class="dashboard__meessage">
                                                <div class="dashboard__meessage__chat">
                                                    <h3>Chats</h3>
                                                </div>
                                                <div class="dashboard__meessage__search">
                                                    <button><i class="icofont-search-1"></i></button>
                                                    <input type="text" placeholder="Search">
                                                </div>

                                                <div class="dashboard__meessage__contact">
                                                    <ul>
                                                        <li>
                                                            <div class="dashboard__meessage__contact__wrap">
                                                                <div class="dashboard__meessage__chat__img">
                                                                    <span
                                                                        class="dashboard__meessage__dot online"></span>
                                                                    <img loading="lazy"
                                                                        src="../img/teacher/teacher__1.png"
                                                                        alt="">
                                                                </div>
                                                                <div class="dashboard__meessage__meta">
                                                                    <h5>Rex Allen</h5>
                                                                    <p class="preview">Hey, How are you?</p>
                                                                    <span class="chat__time">12 min</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="dashboard__meessage__contact__wrap">
                                                                <div class="dashboard__meessage__chat__img">
                                                                    <span
                                                                        class="dashboard__meessage__dot online"></span>
                                                                    <img loading="lazy"
                                                                        src="../img/teacher/teacher__2.png"
                                                                        alt="">
                                                                </div>
                                                                <div class="dashboard__meessage__meta">
                                                                    <h5>Rex Allen</h5>
                                                                    <p class="preview">Hey, How are you?</p>
                                                                    <span class="chat__time">4:35pm</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="dashboard__meessage__contact__wrap">
                                                                <div class="dashboard__meessage__chat__img">
                                                                    <span
                                                                        class="dashboard__meessage__dot online"></span>
                                                                    <img loading="lazy"
                                                                        src="../img/teacher/teacher__3.png"
                                                                        alt="">
                                                                </div>
                                                                <div class="dashboard__meessage__meta">
                                                                    <h5>Julia Jhones</h5>
                                                                    <p class="preview">Hey, How are you?</p>
                                                                    <span class="chat__time">1:40pm</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="dashboard__meessage__contact__wrap">
                                                                <div class="dashboard__meessage__chat__img">
                                                                    <span
                                                                        class="dashboard__meessage__dot online"></span>
                                                                    <img loading="lazy"
                                                                        src="../img/teacher/teacher__4.png"
                                                                        alt="">
                                                                </div>
                                                                <div class="dashboard__meessage__meta">
                                                                    <h5>Anderson</h5>
                                                                    <p class="preview">Hey, How are you?</p>
                                                                    <span class="chat__time">3:20am</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="dashboard__meessage__contact__wrap">
                                                                <div class="dashboard__meessage__chat__img">
                                                                    <span
                                                                        class="dashboard__meessage__dot online"></span>
                                                                    <img loading="lazy"
                                                                        src="../img/teacher/teacher__5.png"
                                                                        alt="">
                                                                </div>
                                                                <div class="dashboard__meessage__meta">
                                                                    <h5>Rex Allen</h5>
                                                                    <p class="preview">Hey, How are you?</p>
                                                                    <span class="chat__time">12 min</span>
                                                                </div>
                                                            </div>
                                                        </li>

                                                        <li>
                                                            <div class="dashboard__meessage__contact__wrap">
                                                                <div class="dashboard__meessage__chat__img">
                                                                    <span
                                                                        class="dashboard__meessage__dot online"></span>
                                                                    <img loading="lazy"
                                                                        src="../img/teacher/teacher__6.png"
                                                                        alt="">
                                                                </div>
                                                                <div class="dashboard__meessage__meta">
                                                                    <h5>Rex Allen</h5>
                                                                    <p class="preview">Hey, How are you?</p>
                                                                    <span class="chat__time">12 min</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="dashboard__meessage__contact__wrap">
                                                                <div class="dashboard__meessage__chat__img">
                                                                    <span
                                                                        class="dashboard__meessage__dot online"></span>
                                                                    <img loading="lazy"
                                                                        src="../img/teacher/teacher__2.png"
                                                                        alt="">
                                                                </div>
                                                                <div class="dashboard__meessage__meta">
                                                                    <h5>Rex Allen</h5>
                                                                    <p class="preview">Hey, How are you?</p>
                                                                    <span class="chat__time">4:35pm</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div class="dashboard__meessage__contact__wrap">
                                                                <div class="dashboard__meessage__chat__img">
                                                                    <span
                                                                        class="dashboard__meessage__dot online"></span>
                                                                    <img loading="lazy"
                                                                        src="../img/teacher/teacher__1.png"
                                                                        alt="">
                                                                </div>
                                                                <div class="dashboard__meessage__meta">
                                                                    <h5>Julia Jhones</h5>
                                                                    <p class="preview">Hey, How are you?</p>
                                                                    <span class="chat__time">1:40pm</span>
                                                                </div>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="col-xl-7 col-lg-6 col-md-12 col-12">
                                            <div class="dashboard__meessage__content__wrap">
                                                <div class="dashboard__meessage__profile">
                                                    <div class="dashboard__meessage__profile__img">
                                                        <img loading="lazy" src="../img/teacher/teacher__2.png"
                                                            alt="">
                                                    </div>
                                                    <div class="dashboard__meessage__profile__meta">
                                                        <h5>Bradshaw</h5>
                                                        <p>Stay at home, Stay safe</p>
                                                    </div>
                                                    <div class="dashboard__meessage__profile__chat__option">
                                                        <a href="admin-dashboard.html"><i
                                                                class="icofont-phone"></i></a>
                                                        <a href="admin-dashboard.html"><i
                                                                class="icofont-ui-video-chat"></i></a>
                                                    </div>
                                                </div>
                                                <div class="dashboard__meessage__sent">
                                                    <ul>
                                                        <li>
                                                            <div class="dashboard__meessage__sent__item__img">
                                                                <img loading="lazy"
                                                                    src="../img/teacher/teacher__1.png"
                                                                    alt="">
                                                            </div>

                                                            <div class="dashboard__meessage__sent__item__content">
                                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing
                                                                    sed.</p>
                                                                <span class="time">4:32 PM</span>
                                                                <p>Dolor sit amet consectetur</p>
                                                                <span class="time">4:30 PM</span>
                                                            </div>
                                                        </li>
                                                        <li class="dashboard__meessage__sent__item">

                                                            <div class="dashboard__meessage__sent__item__content">
                                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing
                                                                    sed.</p>
                                                                <span class="time">4:40 PM</span>
                                                                <p>Dolor sit amet consectetur</p>
                                                                <span class="time">4:42 PM</span>
                                                            </div>
                                                            <div class="dashboard__meessage__sent__item__img">
                                                                <img loading="lazy"
                                                                    src="../img/teacher/teacher__3.png"
                                                                    alt="">
                                                            </div>
                                                        </li>
                                                        <li class="sent">
                                                            <div class="dashboard__meessage__sent__item__img">
                                                                <img loading="lazy"
                                                                    src="../img/teacher/teacher__4.png"
                                                                    alt="">
                                                            </div>
                                                            <div class="dashboard__meessage__sent__item__content">
                                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing
                                                                    sed.</p>

                                                                <span class="time">5:01 PM</span>
                                                                <p>Dolor sit amet consectetur</p>
                                                                <span class="time">5:03 PM</span>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="dashboard__meessage__input">
                                                    <input type="text" placeholder="Type something">
                                                    <i class="icofont-attachment attachment" aria-hidden="true"></i>
                                                    <button class="submit"><i
                                                            class="icofont-arrow-right"></i></button>
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
        <!-- dashboardarea__area__end   -->

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
