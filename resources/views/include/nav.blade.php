<!-- headar section start -->
 <style>
    .swal2-container {
        z-index: 999999 !important;
    }
</style>
<header>
    <div class="headerarea headerarea__3 header__sticky header__area">
        <div class="container desktop__menu__wrapper">
            <div class="row">
                <div class="col-xl-2 col-lg-2 col-md-6">
                    <div class="headerarea__left">
                        <div class="headerarea__left__logo" style="padding: 20PX;">

                            <a href="{{ route('home') }}"><img loading="lazy" src="{{ asset('img/logo/logo_1.png') }}"
                                    alt="logo" style="height:80px; "></a>
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
                                src="{{ asset('img/logo/logo_1.png') }}" alt="logo"></a>
                    </div>
                </div>
                <div class="col-6">
                    <div class="header-right-wrap">


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

{{-- 
                        <div class="mobile-off-canvas">
                            <a class="mobile-aside-button" href="#"><i class="icofont-navigation-menu"></i></a>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header section end -->

<!-- Mobile Menu Start Here -->
{{-- <div class="mobile-off-canvas-active">
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
                    <ul>
                        <li><a href="login.html">Login</a></li>
                        <li><a href="login.html">/ Create Account</a></li>
                        <li><a href="login.html">My Account</a></li>
                    </ul>
                </nav>

            </div>

        </div>
      
          

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
</div> --}}
<!-- Mobile Menu end Here -->
