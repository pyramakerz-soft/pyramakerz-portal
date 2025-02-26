<!doctype html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')
    <script src="{{ asset('js/vendor/jquery-3.6.0.min.js') }}"></script> <!-- Ensure jQuery loads first -->

</head>

<body class="body__wrapper">
    @include('include.load')
    @include('include.preload')

    <main class="main_wrapper overflow-hidden">
        @include('include.nav')

        <!-- breadcrumbarea__section__start -->
        <div class="breadcrumbarea breadcrumbarea--2">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="breadcrumb__content__wraper" data-aos="fade-up">
                            <div class="breadcrumb__inner text-start">
                                <ul>
                                    <li><a href="/">Home</a></li>
                                    <li><a
                                            href="{{ route('instructor.course_details', $course->id) }}">{{ $course->name }}</a>
                                    </li>
                                    <li>Create Group</li>
                                </ul>
                            </div>
                        </div>

                        <div class="course__details__top--2">
                            <div class="course__details__heading" data-aos="fade-up">
                                <h3>Create a New Group for {{ $course->name }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- breadcrumbarea__section__end-->

        <div class="blogarea__2 sp_top_100 sp_bottom_100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-8">
                        <div class="blog__details__content__wraper">
                            <div class="experence__heading">
                                <h5>New Group Details</h5>
                            </div>

                            <form method="POST" action="{{ route('instructor.create_group') }}">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">

                                <div class="form-group">
                                    <label for="name">Group Name:</label>
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>

                                <div class="form-group">
                                    <label for="description">Description (Optional):</label>
                                    <textarea name="description" id="description" class="form-control"></textarea>
                                </div>

                                <button type="submit" class="btn btn-black mt-3">
                                    <i class="icofont-plus"></i> Create Group
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-xl-4 col-lg-4">
                        <div class="course__details__sidebar--2">
                            <div class="event__sidebar__wraper" data-aos="fade-up">
                                <div class="course__summery__button">
                                    <a class="default__button" href="{{ route('instructor.groups', $course->id) }}">
                                        <i class="icofont-arrow-left"></i> Back to Groups
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        @include('include.footer')
@include('include.scripts')
    </main>
</body>

</html>
