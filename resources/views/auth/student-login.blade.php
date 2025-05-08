<!doctype html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')
    @php $openSignup = $errors->any() && old('signup') === '1'; @endphp
    @php
    $arabicCountries = [
    "Egypt", "Saudi Arabia", "United Arab Emirates", "Jordan", "Lebanon", "Morocco",
    "Algeria", "Tunisia", "Sudan", "Iraq", "Syria", "Palestine", "Yemen", "Qatar",
    "Kuwait", "Bahrain", "Oman", "Libya", "Mauritania", "Somalia", "Djibouti", "Comoros"
    ];
    @endphp

</head>


<body class="body__wrapper">
    <!-- pre loader area start -->
    @include('include.load')


    <!-- pre loader area end -->



    <main class="main_wrapper overflow-hidden">




        @include('include.nav')


        <!-- theme fixed shadow -->
        <div>
            <div class="theme__shadow__circle"></div>
            <div class="theme__shadow__circle shadow__right"></div>
        </div>
        <!-- theme fixed shadow -->

        <!-- breadcrumbarea__section__start -->

        <div class="breadcrumbarea">

            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="breadcrumb__content__wraper" data-aos="fade-up">
                            <div class="breadcrumb__title">
                                <h2 class="heading">Log In</h2>
                            </div>
                            <div class="breadcrumb__inner">
                                <ul>
                                    <li><a href="{{route('courses.all')}}">Home</a></li>
                                    <li>Log In</li>
                                </ul>
                            </div>
                        </div>



                    </div>
                </div>
            </div>

            <div class="shape__icon__2">
                <img loading="lazy" class=" shape__icon__img shape__icon__img__1" src="img/herobanner/herobanner__1.png"
                    alt="photo">
                <img loading="lazy" class=" shape__icon__img shape__icon__img__2" src="img/herobanner/herobanner__2.png"
                    alt="photo">
                <img loading="lazy" class=" shape__icon__img shape__icon__img__3" src="img/herobanner/herobanner__3.png"
                    alt="photo">
                <img loading="lazy" class=" shape__icon__img shape__icon__img__4" src="img/herobanner/herobanner__5.png"
                    alt="photo">
            </div>

        </div>
        <!-- breadcrumbarea__section__end-->

        <!-- login__section__start -->
        <div class="loginarea sp_top_100 sp_bottom_100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-md-8 offset-md-2" data-aos="fade-up">
                        <ul class="nav  tab__button__wrap text-center" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button id="loginTab" class="single__tab__link {{ !$openSignup ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#projects__one" type="button">Login</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button id="signupTab" class="single__tab__link {{ $openSignup ? 'active' : '' }}" data-bs-toggle="tab" data-bs-target="#projects__two" type="button">Signup</button>
                            </li>
                        </ul>

                    </div>


                    <div class="tab-content tab__content__wrapper" id="myTabContent" data-aos="fade-up">

                        <div class="tab-pane fade {{ !$openSignup ? 'active show' : '' }}" id="projects__one" role="tabpanel" aria-labelledby="projects__one">
                            <div class="col-xl-8 col-md-8 offset-md-2">
                                <div class="loginarea__wraper">
                                    <div class="login__heading">
                                        <h5 class="login__title">Login</h5>
                                        <p class="login__description">Don't have an account yet?
                                            <a href="#" onclick="openSignupTab()">Sign up for free</a>
                                        </p>
                                    </div>
                                    <form action="{{ route('student-login') }}" method="POST">
                                        @csrf
                                        <div class="login__form">
                                            <label class="form__label">email</label>
                                            <input class="common__login__input" type="text" name="email"
                                                placeholder="email" required>

                                            @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror

                                        </div>
                                        <div class="login__form">
                                            <label class="form__label">Password</label>
                                            <input class="common__login__input" type="password" placeholder="Password"
                                                name="password" required>

                                            @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror

                                        </div>
                                        <div class="login__form d-flex justify-content-between flex-wrap gap-2">
                                            <div class="form__check">
                                                <input id="forgot" type="checkbox">
                                                <label for="forgot"> Remember me</label>
                                            </div>
                                            {{-- <div class="text-end login__form__link">
                                                <a href="#">Forgot your password?</a>
                                            </div> --}}
                                        </div>
                                        <div class="login__social__option">

                                            <input class="default__button" type="submit" value="Log In">
                                        </div>
                                    </form>

                                    {{-- <div class="login__social__option">
                                        <p>or Log-in with</p>

                                        <ul class="login__social__btn">
                                            <li><a class="default__button login__button__1" href="#"><i
                                                        class="icofont-facebook"></i> Gacebook</a></li>
                                            <li><a class="default__button" href="#"><i
                                                        class="icofont-google-plus"></i> Google</a></li>
                                        </ul>
                                    </div> --}}


                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade {{ $openSignup ? 'active show' : '' }}" id="projects__two" role="tabpanel" aria-labelledby="projects__two">
                            <div class="col-xl-8 offset-md-2">
                                <div class="loginarea__wraper">
                                    <div class="login__heading">
                                        <h5 class="login__title">sign up</h5>
                                        <p class="login__description">Already have an account?
                                            <a href="#" onclick="openLoginTab()">Log In</a>
                                        </p>
                                    </div>



                                    <form action="{{ route('register-student') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="signup" value="1">

                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="login__form">
                                                    <label class="form__label">Name</label>
                                                    <input class="common__login__input" type="text" name="name" value="{{ old('name') }}" placeholder="Name" required>
                                                    @error('name')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="login__form">
                                                    <label class="form__label">Email</label>
                                                    <input class="common__login__input" type="email" name="email" value="{{ old('email') }}" placeholder="Your Email" required autocomplete="off">
                                                    @error('email')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="login__form">
                                                    <label class="form__label">Phone Number</label>
                                                    <input class="common__login__input" type="text" name="phone" value="{{ old('phone') }}" placeholder="Phone Number" required>
                                                    @error('phone')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="login__form">
                                                    <label class="form__label">Parent's Phone Number</label>
                                                    <input class="common__login__input" type="text" name="parent_phone" value="{{ old('parent_phone') }}" placeholder="Parent Phone Number" required>
                                                    @error('parent_phone')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="login__form">
                                                    <label class="form__label">Birthday</label>
                                                    <input class="common__login__input" type="date" name="bday" value="{{ old('bday') }}" required>
                                                    @error('bday')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="login__form">
                                                    <label class="form__label">Country</label>
                                                    <select class="common__login__input" id="country" name="country" required>
                                                        <option value="" style="color: #5f6c76;">Select Country</option>
                                                        @foreach ($arabicCountries as $country)
                                                        <option value="{{ $country }}" style="color: #5f6c76;">{{ $country }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('country')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="login__form">
                                                    <label class="form__label">City</label>
                                                    <select class="common__login__input mr-2" id="city" name="city" required>
                                                        <option value="">Select City</option>
                                                    </select>
                                                    @error('city')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>


                                            <div class="col-xl-6">
                                                <div class="login__form">
                                                    <label class="form__label">School</label>
                                                    <input class="common__login__input" type="text" name="school" value="{{ old('school') }}" placeholder="School" required>
                                                    @error('school')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="login__form">
                                                    <label class="form__label">Password</label>
                                                    <input class="common__login__input" type="password" name="password" placeholder="Password" required>
                                                    @error('password')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-xl-6">
                                                <div class="login__form">
                                                    <label class="form__label">Re-Enter Password</label>
                                                    <input class="common__login__input" type="password" name="confirm_password" placeholder="Re-Enter Password" required>
                                                    @error('confirm_password')
                                                    <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="login__form d-flex justify-content-between flex-wrap gap-2 mt-3">
                                            <div class="form__check">
                                                <input id="accept_pp" type="checkbox" required>
                                                <label for="accept_pp">Accept the Terms and Privacy Policy</label>
                                            </div>
                                        </div>

                                        <div class="login__social__option mt-3">
                                            <button class="default__button">Signup</button>
                                        </div>
                                    </form>





                                </div>
                            </div>

                        </div>



                    </div>

                </div>

                <div class=" login__shape__img educationarea__shape_image">
                    <img loading="lazy" class="hero__shape hero__shape__1" src="img/education/hero_shape2.png"
                        alt="Shape">
                    <img loading="lazy" class="hero__shape hero__shape__2" src="img/education/hero_shape3.png"
                        alt="Shape">
                    <img loading="lazy" class="hero__shape hero__shape__3" src="img/education/hero_shape4.png"
                        alt="Shape">
                    <img loading="lazy" class="hero__shape hero__shape__4" src="img/education/hero_shape5.png"
                        alt="Shape">
                </div>


            </div>
        </div>

        <!-- login__section__end -->

        <!-- footer__section__start -->
        @include('include.footer')
        @include('include.scripts')

        <!-- footer__section__end -->


    </main>






    <!-- JS here -->
    <script src="js/vendor/modernizr-3.5.0.min.js"></script>
    <script src="js/vendor/jquery-3.6.0.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/isotope.pkgd.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/jquery.meanmenu.min.js"></script>
    <script src="js/ajax-form.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/jquery.scrollUp.min.js"></script>
    <script src="js/imagesloaded.pkgd.min.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/waypoints.min.js"></script>
    <script src="js/jquery.counterup.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/swiper-bundle.min.js"></script>
    <script src="js/main.js"></script>



    <script>
        function openLoginTab() {
            document.getElementById('loginTab').click();
        }

        function openSignupTab() {
            document.getElementById('signupTab').click();
        }
    </script>
    <script>
        const cityOptions = {
            "Egypt": ["Cairo", "Alexandria", "Giza", "Luxor", "Aswan", "Tanta", "Mansoura", "Zagazig", "Ismailia"],
            "Saudi Arabia": ["Riyadh", "Jeddah", "Mecca", "Medina", "Dammam", "Khobar", "Abha", "Tabuk"],
            "United Arab Emirates": ["Abu Dhabi", "Dubai", "Sharjah", "Ajman", "Fujairah", "Ras Al Khaimah"],
            "Jordan": ["Amman", "Zarqa", "Irbid", "Aqaba", "Madaba"],
            "Lebanon": ["Beirut", "Tripoli", "Sidon", "Tyre", "Zahle"],
            "Morocco": ["Casablanca", "Rabat", "Marrakech", "Fes", "Tangier", "Agadir"],
            "Algeria": ["Algiers", "Oran", "Constantine", "Annaba", "Blida"],
            "Tunisia": ["Tunis", "Sfax", "Sousse", "Bizerte", "Gabes"],
            "Sudan": ["Khartoum", "Omdurman", "Port Sudan", "Kassala", "El Obeid"],
            "Iraq": ["Baghdad", "Basra", "Mosul", "Erbil", "Najaf"],
            "Syria": ["Damascus", "Aleppo", "Homs", "Latakia", "Hama"],
            "Palestine": ["Gaza", "Ramallah", "Hebron", "Nablus", "Jericho"],
            "Yemen": ["Sana'a", "Aden", "Taiz", "Al Hudaydah", "Ibb"],
            "Qatar": ["Doha", "Al Rayyan", "Al Wakrah", "Umm Salal", "Al Khor"],
            "Kuwait": ["Kuwait City", "Al Ahmadi", "Hawalli", "Salmiya", "Farwaniya"],
            "Bahrain": ["Manama", "Muharraq", "Riffa", "Isa Town", "Sitra"],
            "Oman": ["Muscat", "Salalah", "Sohar", "Nizwa", "Sur"],
            "Libya": ["Tripoli", "Benghazi", "Misrata", "Sabha", "Zawiya"],
            "Mauritania": ["Nouakchott", "Nouadhibou", "Zouerate", "Rosso", "Kaédi"],
            "Somalia": ["Mogadishu", "Hargeisa", "Bosaso", "Kismayo", "Baidoa"],
            "Djibouti": ["Djibouti", "Ali Sabieh", "Tadjourah", "Obock", "Dikhil"],
            "Comoros": ["Moroni", "Mutsamudu", "Fomboni"]
        };

        document.addEventListener('DOMContentLoaded', function() {
            const countrySelect = document.getElementById("country");
            const citySelect = document.getElementById("city");

            countrySelect.addEventListener("change", function() {
                const selectedCountry = countrySelect.value;
                citySelect.innerHTML = '<option value="" style="color: #5f6c76;">Select City</option>';
                if (cityOptions[selectedCountry]) {
                    cityOptions[selectedCountry].forEach(city => {
                        const option = document.createElement("option");
                        option.value = city;
                        option.text = city;
                        option.style = "color: #5f6c76;";
                        citySelect.appendChild(option);
                    });
                }
            });
        });
    </script>

</body>

</html>