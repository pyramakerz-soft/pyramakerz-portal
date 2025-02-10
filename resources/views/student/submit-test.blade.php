<!DOCTYPE html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')
</head>

<body class="body__wrapper">
    @include('include.preload')

    <main class="main_wrapper overflow-hidden">
        @include('include.nav')

        <!-- Theme Fixed Shadow -->
        <div>
            <div class="theme__shadow__circle"></div>
            <div class="theme__shadow__circle shadow__right"></div>
        </div>

        <!-- Dashboard Area Start -->
        <div class="dashboardarea sp_bottom_100">
            @include('include.stud-topbar')
            <div class="dashboard">
                <div class="container-fluid full__width__padding">
                    <div class="row">
                        <!-- Sidebar -->
                        <div class="col-xl-3 col-lg-3 col-md-12">
                            @include('include.stud-sidebar')
                        </div>

                        <!-- Main Content -->
                        <div class="col-xl-9 col-lg-9 col-md-12">
                            <div class="dashboard__content__wraper">
                                <div class="dashboard__section__title">
                                    <h4>{{ $test->name }}</h4>
                                </div>

                                <hr class="mt-40">

                                <form action="{{ route('submit-test', $test->id) }}" method="POST">
                                    @csrf
                                    
                                    @foreach($test->questions as $question)
                                    <div class="mb-4">
                                        <h5>{{ $loop->iteration }}. {{ $question->text }}</h5>

                                        @php
                                            $choices = json_decode($question->choices, true); // Convert JSON to array
                                        @endphp

                                        @if(is_array($choices))
                                        <div class="mt-2">
                                            @foreach($choices as $choice)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]" value="{{ $choice }}" id="choice_{{ $question->id }}_{{ $loop->index }}" required>
                                                <label class="form-check-label" for="choice_{{ $question->id }}_{{ $loop->index }}">
                                                    {{ $choice }}
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                    @endforeach

                                    <div class="mt-4">
                                        <button type="submit" class="dashboard__small__btn__2 dashboard__small__btn__3">
                                            <i class="icofont-paper-plane"></i> Submit Answers
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        @include('include.footer')
    </main>

    <!-- JS Scripts -->
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
