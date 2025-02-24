<!DOCTYPE html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')
</head>

<body class="body__wrapper">
    @include('include.load')
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
                                    <h4>{{ $test->name }} - Results</h4>
                                </div>

                                <hr class="mt-40">

                                @foreach ($test->questions as $question)
                                    <div class="mb-4">
                                        <h5>{{ $loop->iteration }}. {{ $question->text }}</h5>

                                        @php
                                            $choices = json_decode($question->choices, true);
                                            $studentAnswer = $studentAnswers
                                                ->where('question_id', $question->id)
                                                ->first();
                                        @endphp

                                        @if (is_array($choices))
                                            <ul class="list-group">
                                                @foreach ($choices as $choice)
                                                    <li
                                                        class="list-group-item 
                                            @if ($studentAnswer && $studentAnswer->selected_choice == $choice) list-group-item-success @endif
                                            ">
                                                        {{ $choice }}
                                                        @if ($studentAnswer && $studentAnswer->selected_choice == $choice)
                                                            ✅ Your Answer
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                @endforeach

                                <div class="mt-4">
                                    <a href="{{ route('view-test', $test->id) }}" class="dashboard__small__btn__2">
                                        <i class="icofont-refresh"></i> Retake Test
                                    </a>
                                </div>

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
