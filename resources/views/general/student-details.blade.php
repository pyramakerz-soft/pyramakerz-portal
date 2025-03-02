<!doctype html>
<html class="no-js" lang="zxx">
@include('include.head')

<body class="body__wrapper">

    @include('include.load')
    <main class="main_wrapper overflow-hidden">
        @include('include.dash-nav')

        <!-- dashboardarea__area__start  -->
        <div class="dashboardarea ">
            @include('include.stud-topbar')
            <div class="dashboard">
                <div class="container-fluid full__width__padding">
                    <div class="row">
                        <div class="col-xl-3 col-lg-3 col-md-12">
                            @include('include.stud-sidebar')

                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-12">
                            <div class="dashboard">
                                <div class="container-fluid ">


                                    <!-- Filters -->
                                    <div class="dashboard__content__wraper">
                                        <div class="dashboard__section__title">
                                            <h4>👩‍🎓 Student name from datbase</h4>
                                            <h4>Course Name : group name</h4>
                                            <h4> Instructor name</h4>

                                        </div>


                                        <!-- Progress Table -->
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead class="  headtb text-white">
                                                    <tr>
                                                        <th>Lesson Name</th>
                                                        <th>Date</th>
                                                        <th>Absent</th>
                                                        <th> Interaction</th>
                                                        <th> Performance</th>
                                                        <th>Homework</th>
                                                        <th>Project</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    {{-- @forelse () --}}
                                                    <tr>
                                                        {{-- <td>{{ $progress->branch }}</td>
                                                        <td>{{ $progress->course->name }}</td>
                                                        <td>{{ $progress->age_group }}</td>
                                                        <td>{{ $progress->start_time }} - {{ $progress->end_time }}</td>
                                                        <td>{{ $progress->status }}</td>
                                                        <td>{{ $progress->instructor->name }}</td>
                                                        <td>{{ json_encode($progress->progress) }}</td>
                                                        <td>{{ json_encode($progress->materials) }}</td> --}}
                                                    </tr>
                                                    {{-- @empty --}}
                                                    <tr>
                                                        <td colspan="8" class="text-center">No Progress Data Found.
                                                        </td>
                                                    </tr>
                                                    {{-- @endforelse --}}
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

        <!-- Summary Section -->


        </div>
    </main>

</body>
<script src="{{ asset('js/vendor/modernizr-3.5.0.min.js') }}"></script>
<script src="{{ asset('js/vendor/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('js/slick.min.js') }}"></script>
<script src="{{ asset('js/jquery.meanmenu.min.js') }}"></script>
<script src="{{ asset('js/ajax-form.js') }}"></script>
<script src="{{ asset('js/wow.min.js') }}"></script>
<script src="{{ asset('js/jquery.scrollUp.min.js') }}"></script>
<script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('js/waypoints.min.js') }}"></script>
<script src="{{ asset('js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('js/plugins.js') }}"></script>
<script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

</html>
