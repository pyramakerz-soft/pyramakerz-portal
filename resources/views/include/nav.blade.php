<!-- headar section start -->
<header>
    <div class="headerarea headerarea__3 header__sticky header__area">
        <div class="container desktop__menu__wrapper">
            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-6">
                    <div class="headerarea__left">
                        <div class="headerarea__left__logo" style="padding: 20PX;">

                            <a href="{{ route('home') }}"><img loading="lazy"
                                    src="{{asset('img/logo/logo_1.png')}}"
                                    alt="logo" style="height:50px; "></a>
                        </div>

                    </div>
                </div>
                <div class="col-xl-7 col-lg-7 main_menu_wrap">

                </div>
                <div class="col-xl-3 col-lg-3 col-md-6">
                    <div class="headerarea__right">



                        <div class="headerarea__button">
                            @if (Auth::guard('student')->user())
                                <a>Hello,
                                    {{ Auth::guard('student')->user()->name }}
                                </a>
                            @elseif (Auth::guard('admin')->user())
                                <a>Hello,
                                    {{ Auth::guard('admin')->user()->name }}
                                </a>
                            @else
                                <a href="{{ route('student-login') }}">Get Started</a>
                            @endif
                        </div>

                    </div>
                </div>

            </div>

        </div>


        <div class="container-fluid mob_menu_wrapper">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="mobile-logo">
                        <a class="logo__dark" href="{{ route('home') }}"><img loading="lazy"
                                src="{{asset('img/logo/logo_1.png')}}"
                                alt="logo"></a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="header-right-wrap">



                        <div class="mobile-off-canvas">
                            <a class="mobile-aside-button" href="#"><i class="icofont-navigation-menu"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header section end -->

<!-- Mobile Menu Start Here -->
<div class="mobile-off-canvas-active">
    <a class="mobile-aside-close"><i class="icofont  icofont-close-line"></i></a>
    <div class="header-mobile-aside-wrap">
        <div class="mobile-search">
            <form class="search-form" action="#">
                <input type="text" placeholder="Search entire store…">
                <button class="button-search"><i class="icofont icofont-search-2"></i></button>
            </form>
        </div>
        <div class="mobile-menu-wrap headerarea">

            <div class="mobile-navigation">

                <nav>
                    <ul class="mobile-menu">
                        <li class="menu-item-has-children"><a href="index.html">Home</a>
                            <ul class="dropdown">
                                <li class="menu-item-has-children"><a href="index.html">Homes Light</a>
                                    <ul class="dropdown">
                                        <li><a href="index.html">Home (Default)</a></li>
                                        <li><a href="home-2.html">Elegant</a></li>
                                        <li><a href="home-3.html">Classic</a></li>
                                        <li><a href="home-4.html">Classic LMS</a></li>
                                        <li><a href="home-5.html">Online Course </a></li>
                                        <li><a href="home-6.html">Marketplace </a></li>
                                        <li><a href="home-7.html">University</a></li>
                                        <li><a href="home-8.html">eCommerce</a></li>
                                        <li><a href="home-9.html">Kindergarten</a></li>
                                        <li><a href="home-10.html">Machine Learning</a></li>
                                        <li><a href="home-11.html">Single Course</a></li>
                                    </ul>
                                </li>

                                <li class="menu-item-has-children">
                                    <a href="index.html">Homes Dark</a>
                                    <ul class="dropdown">
                                        <li><a href="index-dark.html">Home Default (Dark)</a></li>
                                        <li><a href="home-2-dark.html">Elegant (Dark)</a></li>
                                        <li><a href="home-3-dark.html">Classic (Dark)</a></li>
                                        <li><a href="home-4-dark.html">Classic LMS (Dark)</a></li>
                                        <li><a href="home-5-dark.html">Online Course (Dark)</a></li>
                                        <li><a href="home-6-dark.html">Marketplace (Dark)</a></li>
                                        <li><a href="home-7-dark.html">University (Dark)</a></li>
                                        <li><a href="home-8-dark.html">eCommerce (Dark)</a></li>
                                        <li><a href="home-9-dark.html">Kindergarten (Dark)</a></li>
                                        <li><a href="home-10-dark.html">Kindergarten (Dark)</a></li>
                                        <li><a href="home-11-dark.html">Single Course (Dark)</a></li>
                                    </ul>
                                </li>

                            </ul>
                        </li>


                        <li class="menu-item-has-children "><a href="#">Pages</a>

                            <ul class="dropdown">
                                <li class="menu-item-has-children">
                                    <a href="#">Get Started 1</a>

                                    <ul class="dropdown">
                                        <li><a href="about.html">About</a></li>
                                        <li><a href="about-dark.html">About (Dark)<span
                                                    class="mega__menu__label new">New</span></a></li>
                                        <li><a href="blog.html">Blog</a></li>
                                        <li><a href="blog-dark.html">Blog (Dark)</a></li>
                                        <li><a href="blog-details.html">Blog Details</a></li>
                                        <li><a href="blog-details-dark.html">Blog Details (Dark)</a></li>
                                    </ul>
                                </li>

                                <li class="menu-item-has-children">
                                    <a href="#">Get Started 2</a>
                                    <ul class="dropdown">
                                        <li><a href="error.html">Error 404</a></li>
                                        <li><a href="error-dark.html">Error (Dark)</a></li>
                                        <li><a href="event-details.html">Event Details</a></li>
                                        <li><a href="zoom/zoom-meetings.html">Zoom<span class="mega__menu__label">Online
                                                    Call</span></a></li>
                                        <li><a href="zoom/zoom-meetings-dark.html">Zoom Meeting (Dark)</a></li>
                                        <li><a href="zoom/zoom-meeting-details.html">Zoom Meeting Details</a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="menu-item-has-children">
                                    <a href="#">Get Started 3</a>
                                    <ul class="dropdown">
                                        <li><a href="zoom/zoom-meeting-details-dark.html">Meeting Details
                                                (Dark)</a>
                                        </li>
                                        <li><a href="login.html">Login</a></li>
                                        <li><a href="login-dark.html">Login (Dark)</a></li>
                                        <li><a href="maintenance.html">Maintenance</a></li>
                                        <li><a href="maintenance-dark.html">Maintenance Dark</a></li>
                                        <li><a href="#">Terms & Condition</a></li>
                                    </ul>
                                </li>

                                <li class="menu-item-has-children">
                                    <a href="#">Get Started 4</a>
                                    <ul class="dropdown">
                                        <li><a href="#">Terms & Condition (Dark)</a></li>
                                        <li><a href="contact.html">Contact</a></li>
                                        <li><a href="contact-dark.html">Contact (Dark)</a></li>
                                        <li><a href="#">Success Stories</a></li>
                                        <li><a href="#">Success Stories (Dark)</a></li>
                                        <li><a href="#">Work Policy</a></li>
                                    </ul>
                                </li>

                                <li class="menu-item-has-children">
                                    <div class="mega__menu__img">
                                        <a href="#"><img loading="lazy" src="img/mega/mega_menu_2.png"
                                                alt="Mega Menu"></a>
                                    </div>
                                </li>
                            </ul>
                        </li>



                        <li class="menu-item-has-children "><a href="course.html">Courses</a>

                            <ul class="dropdown">
                                <li class="menu-item-has-children">
                                    <a href="#">Get Started 1</a>

                                    <ul class="dropdown">
                                        <li><a href="course.html">Grid <span class="mega__menu__label">All
                                                    Courses</span></a></li>
                                        <li><a href="course-dark.html">Course Grid (Dark)</a></li>
                                        <li><a href="course-grid.html">Course Grid</a></li>
                                        <li><a href="course-grid-dark.html">Course Grid (Dark)</a></li>
                                        <li><a href="course-list.html">Course List</a></li>
                                        <li><a href="course-list-dark.html">Course List (Dark)</a></li>
                                    </ul>
                                </li>

                                <li class="menu-item-has-children">
                                    <a href="#">Get Started 2</a>
                                    <ul class="dropdown">
                                        <li><a href="course-details.html">Course Details</a></li>
                                        <li><a href="course-details-dark.html">Course Details (Dark)</a></li>
                                        <li><a href="course-details-2.html">Course Details 2</a></li>
                                        <li><a href="course-details-2-dark.html">Details 2 (Dark)</a></li>
                                        <li><a href="course-details-3.html">Course Details 3</a></li>
                                        <li><a href="course-details-3.html">Details 3 (Dark)</a></li>
                                    </ul>
                                </li>

                                <li class="menu-item-has-children">
                                    <a href="#">Get Started 3</a>
                                    <ul class="dropdown">
                                        <li><a href="dashboard/become-an-instructor.html">Become An
                                                Instructor</a>
                                        <li><a href="dashboard/create-course.html">Create Course <span
                                                    class="mega__menu__label">Career</span></a></li>
                                        <li><a href="instructor.html">Instructor</a></li>
                                        <li><a href="instructor-dark.html">Instructor (Dark)</a></li>
                                        <li><a href="instructor-details.html">Instructor Details</a></li>
                                        <li><a href="lesson.html">Course Lesson<span
                                                    class="mega__menu__label new">New</span></a></li>
                                    </ul>
                                </li>

                                <li class="menu-item-has-children">
                                    <div class="mega__menu__img">
                                        <a href="#"><img loading="lazy" src="img/mega/mega_menu_1.png"
                                                alt="Mega Menu"></a>
                                    </div>
                                </li>
                            </ul>
                        </li>


                        <li class="menu-item-has-children "><a href="dashboard/admin-dashboard.html">Dashboard</a>

                            <ul class="dropdown">
                                <li class="menu-item-has-children">
                                    <a href="#">Admin</a>

                                    <ul class="dropdown">
                                        <li><a href="dashboard/admin-dashboard.html">Admin Dashboard</a></li>
                                        <li><a href="dashboard/admin-profile.html">Admin Profile</a></li>
                                        <li><a href="dashboard/admin-message.html">Message</a></li>
                                        <li><a href="dashboard/admin-course.html">Courses</a></li>
                                        <li><a href="dashboard/admin-reviews.html">Review</a></li>
                                        <li><a href="dashboard/admin-quiz-attempts.html">Admin Quiz</a></li>

                                        <li><a href="dashboard/admin-settings.html">Settings</a></li>
                                    </ul>
                                </li>

                                <li class="menu-item-has-children">
                                    <a href="#">Instructor</a>
                                    <ul class="dropdown">
                                        <li><a href="dashboard/instructor-dashboard.html">Inst. Dashboard</a>
                                        </li>
                                        <li><a href="dashboard/instructor-profile.html">Inst. Profile</a></li>
                                        <li><a href="dashboard/instructor-message.html">Message</a></li>
                                        <li><a href="dashboard/instructor-wishlist.html">Wishlist</a></li>
                                        <li><a href="dashboard/instructor-reviews.html">Review</a></li>
                                        <li><a href="dashboard/instructor-my-quiz-attempts.html">My Quiz</a>
                                        </li>
                                        <li><a href="dashboard/instructor-order-history.html">Order History</a>
                                        </li>
                                        <li><a href="dashboard/instructor-course.html">My Courses</a></li>
                                        <li><a href="dashboard/instructor-announcments.html">Announcements</a>
                                        </li>
                                        <li><a href="dashboard/instructor-quiz-attempts.html">Quiz Attempts</a>
                                        </li>
                                        <li><a href="dashboard/instructor-assignments.html">Assignment</a></li>
                                        <li><a href="dashboard/instructor-settings.html">Settings</a></li>
                                    </ul>
                                </li>

                                <li class="menu-item-has-children">
                                    <a href="#">Student</a>
                                    <ul class="dropdown">
                                        <li><a href="dashboard/student-dashboard.html">Dashboard</a></li>
                                        <li><a href="dashboard/student-profile.html">Profile</a></li>
                                        <li><a href="dashboard/student-message.html">Message</a></li>
                                        <li><a href="dashboard/student-enrolled-courses.html">Enrolled
                                                Courses</a></li>
                                        <li><a href="dashboard/student-wishlist.html">Wishlist</a></li>
                                        <li><a href="dashboard/student-reviews.html">Review</a></li>
                                        <li><a href="dashboard/student-my-quiz-attempts.html">My Quiz</a></li>
                                        <li><a href="dashboard/student-assignments.html">Assignment</a></li>
                                        <li><a href="dashboard/student-settings.html">Settings</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <li class="menu-item-has-children"><a href="ecommerce/shop.html">eCommerce</a>
                            <ul class="dropdown">
                                <li><a href="ecommerce/shop.html">Shop<span class="mega__menu__label">Online
                                            Store</span></a></li>
                                <li><a href="ecommerce/product-details.html">Product Details</a></li>
                                <li><a href="ecommerce/cart.html">Cart</a></li>
                                <li><a href="ecommerce/checkout.html">Checkout</a></li>
                                <li><a href="ecommerce/wishlist.html">Wishlist</a></li>

                            </ul>
                        </li>

                    </ul>
                </nav>

            </div>

        </div>
        <div class="mobile-curr-lang-wrap">
            <div class="single-mobile-curr-lang">
                <a class="mobile-language-active" href="#">Language <i class="icofont-thin-down"></i></a>
                <div class="lang-curr-dropdown lang-dropdown-active">
                    <ul>
                        <li><a href="#">English (US)</a></li>
                        <li><a href="#">English (UK)</a></li>
                        <li><a href="#">Spanish</a></li>
                    </ul>
                </div>
            </div>

            <!-- <div class="single-mobile-curr-lang">
                          <a class="mobile-currency-active" href="#">Currency <i class="icofont-thin-down"></i></a>
                          <div class="lang-curr-dropdown curr-dropdown-active">
                              <ul>
                                  <li><a href="#">USD</a></li>
                                  <li><a href="#">EUR</a></li>
                                  <li><a href="#">Real</a></li>
                                  <li><a href="#">BDT</a></li>
                              </ul>
                          </div>
                      </div> -->

            <div class="single-mobile-curr-lang">
                <a class="mobile-account-active" href="#">My Account <i class="icofont-thin-down"></i></a>
                <div class="lang-curr-dropdown account-dropdown-active">
                    <ul>
                        <li><a href="login.html">Login</a></li>
                        <li><a href="login.html">/ Create Account</a></li>
                        <li><a href="login.html">My Account</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mobile-social-wrap">
            <a class="facebook" href="#"><i class="icofont icofont-facebook"></i></a>
            <a class="twitter" href="#"><i class="icofont icofont-twitter"></i></a>
            <a class="pinterest" href="#"><i class="icofont icofont-pinterest"></i></a>
            <a class="instagram" href="#"><i class="icofont icofont-instagram"></i></a>
            <a class="google" href="#"><i class="icofont icofont-youtube-play"></i></a>
        </div>
    </div>
</div>
<!-- Mobile Menu end Here -->
