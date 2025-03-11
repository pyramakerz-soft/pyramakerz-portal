<!DOCTYPE html>
<html class="no-js " lang="zxx">

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

                                {{-- <div class="card shadow-lg border-0 rounded-lg"> --}}
                                <div class="card-header bg-primary text-white">
                                    <h4 class="mb-0 ">📊 Session Evaluation</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('meetings.evaluate.submit', $meeting->id) }}" method="POST">
                                        @csrf

                                        <!-- Session Information -->
                                        <div class="mb-3">
                                            <strong>📚 Session:</strong> {{ $meeting->topic }} <br>
                                            <strong>👨‍🏫 Instructor:</strong> {{ $meeting->group->instructor->name }}
                                            <br>
                                            <strong>📅 Date:</strong>
                                            {{ \Carbon\Carbon::parse($meeting->start_time)->format('M d, Y') }} <br>
                                        </div>

                                        <hr>

                                        <!-- Ratings Section -->

                                        <div class="row">
                                            <!-- Content Quality -->
                                            <div class=" col-xl-6 col-lg-6 col-md-12 mb-3">
                                                <label class="form-label">📖 Content Quality</label>
                                                <div class="rating">
                                                    @for ($i = 5; $i >= 1; $i--)
                                                        <input type="radio" name="content_quality"
                                                            value="{{ $i }}" id="content-{{ $i }}"
                                                            required>
                                                        <label for="content-{{ $i }}">★</label>
                                                    @endfor
                                                </div>
                                            </div>

                                            <!-- Instructor Clarity -->
                                            <div class=" col-xl-6 col-lg-6 col-md-12 mb-3">
                                                <label class="form-label">🗣️ Instructor's Clarity</label>
                                                <div class="rating">
                                                    @for ($i = 5; $i >= 1; $i--)
                                                        <input type="radio" name="instructor_clarity"
                                                            value="{{ $i }}" id="clarity-{{ $i }}"
                                                            required>
                                                        <label for="clarity-{{ $i }}">★</label>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Engagement -->
                                        <div class="row">
                                            <!-- Content Quality -->
                                            <div class=" col-xl-6 col-lg-6 col-md-12 mb-3">
                                                <label class="form-label">🎭 Student Engagement</label>
                                                <div class="rating">
                                                    @for ($i = 5; $i >= 1; $i--)
                                                        <input type="radio" name="engagement"
                                                            value="{{ $i }}"
                                                            id="engagement-{{ $i }}" required>
                                                        <label for="engagement-{{ $i }}">★</label>
                                                    @endfor
                                                </div>
                                            </div>

                                            <!-- Pace of the session -->
                                            <div class=" col-xl-6 col-lg-6 col-md-12 mb-3">

                                                <label class="form-label">⏳ Pace of the Session</label>
                                                <div class="rating">
                                                    @for ($i = 5; $i >= 1; $i--)
                                                        <input type="radio" name="pace"
                                                            value="{{ $i }}" id="pace-{{ $i }}"
                                                            required>
                                                        <label for="pace-{{ $i }}">★</label>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class=" col-xl-6 col-lg-6 col-md-12 mb-3">

                                                <!-- Technology and tools -->

                                                <label class="form-label">🖥️ Technology & Tools Used</label>
                                                <div class="rating">
                                                    @for ($i = 5; $i >= 1; $i--)
                                                        <input type="radio" name="technology_usage"
                                                            value="{{ $i }}" id="tech-{{ $i }}"
                                                            required>
                                                        <label for="tech-{{ $i }}">★</label>
                                                    @endfor
                                                </div>
                                            </div>

                                            <!-- Overall Experience -->
                                            <div class=" col-xl-6 col-lg-6 col-md-12 mb-3">
                                                <label class="form-label">🌟 Overall Experience</label>
                                                <div class="rating">
                                                    @for ($i = 5; $i >= 1; $i--)
                                                        <input type="radio" name="overall_experience"
                                                            value="{{ $i }}"
                                                            id="overall-{{ $i }}" required>
                                                        <label for="overall-{{ $i }}">★</label>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Feedback -->
                                        <div class="mb-3 add__a__review__input ">
                                            <label class="form-label">✍️ Additional Feedback (Optional)</label>
                                            <textarea name="feedback" class="form-control" rows="3" placeholder="Share your thoughts..."></textarea>
                                        </div>

                                        <!-- Submit Button -->
                                        <div class="text-center">
                                            <button type="submit" class="btn default__button px-5">Submit Evaluation
                                            </button>
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
    </main>
    @include('include.footer')
    @include('include.scripts')
</body>

</html>
