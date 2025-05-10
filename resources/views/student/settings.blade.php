<!doctype html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')


</head>


<body class="body__wrapper">

    @include('include.load')



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
                                    <form action="{{ route('update-data') }}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="tab-pane fade active show" id="projects__one" role="tabpanel"
                                            aria-labelledby="projects__one">
                                            <div class="row">
                                                <div class="col-xl-12">

                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="dashboard__form__wraper">
                                                                <div class="dashboard__form__input">
                                                                    <label for="#">Full Name</label>
                                                                    <input type="text" name="name" value="{{ $user->name }}" placeholder="first Name">
                                                                    @error('name')
                                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6">
                                                            <div class="dashboard__form__wraper">
                                                                <div class="dashboard__form__input">
                                                                    <label for="#">Phone Number</label>
                                                                    <input type="text" name="phone" value="{{ $user->phone }}" readonly
                                                                        placeholder="+1-202-555-0174">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6">
                                                            <div class="dashboard__form__wraper">
                                                                <div class="dashboard__form__input">
                                                                    <label for="#">Email</label>
                                                                    <input type="email" name="email" value="{{ $user->email }}" placeholder="email" readonly>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-6">
                                                            <div class="dashboard__form__wraper">
                                                                <div class="dashboard__form__input">
                                                                    <label for="#">Profile picture</label>
                                                                    <input type="file" name="image">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-xl-12">
                                                            <div class="dashboard__form__button">
                                                                <input type="submit" class="default__button" value="Update Info " >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                        <div class="tab-pane fade" id="projects__two" role="tabpanel"
                                            aria-labelledby="projects__two">
                                            <form action="{{ route('change-password', Auth::guard('student')->user()->id) }}" method="post">
                                                @csrf
                                                @method('PUT') 
                                            
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">
                                                                <label for="current_password">Current Password</label>
                                                                <input type="password" name="current_password" placeholder="Current Password" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                            
                                                    <div class="col-xl-12">
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">
                                                                <label for="new_password">New Password</label>
                                                                <input type="password" name="new_password" minlength="8" placeholder="New Password" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                            
                                                    <div class="col-xl-12">
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">
                                                                <label for="new_password_confirmation">Re-Type New Password</label>
                                                                <input type="password" name="new_password_confirmation" minlength="8"  placeholder="Re-Type New Password" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                            
                                                    <div class="col-xl-12">
                                                        <div class="dashboard__form__button">
                                                            <button type="submit" class="default__button">Update Password</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            
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
