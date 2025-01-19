<!doctype html>
<html class="no-js is_dark" lang="zxx">

<head>
    @include('include.head')


</head>


<body class="body__wrapper">

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

        <div class="breadcrumbarea breadcrumbarea--2">

            <div class="container">
                <div class="row">
                    <div class="col-xl-8">


                        <div class="breadcrumb__content__wraper" data-aos="fade-up">
                            <div class="breadcrumb__inner text-start">
                                <ul>
                                    <li><a href="index.html">Home</a></li>
                                    <li>Course-Details 2</li>
                                </ul>
                            </div>
                        </div>

                        <div class="course__details__top--2">

                            <div class="course__button__wraper" data-aos="fade-up">
                                <div class="course__button">
                                    <a href="#">Featured</a>
                                    <a class="course__2" href="#">Ux Design</a>
                                </div>
                            </div>
                            <div class="course__details__heading" data-aos="fade-up">
                                <h3>Making Music with Other People</h3>
                            </div>
                            <div class="course__details__price" data-aos="fade-up">
                                <ul>
                                    <li>
                                        <div class="course__details__date">
                                            <i class="icofont-book-alt"></i> 23 Lesson
                                        </div>

                                    </li>
                                    <li>
                                        <div class="course__star">
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <span>(44)</span>
                                        </div>
                                    </li>

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

        <div class="blogarea__2 sp_top_100 sp_bottom_100">
            <div class="container">
                <div class="row">

                    <div class="col-xl-8 col-lg-8">


                        <div class="blog__details__content__wraper">

                            <div class="course__details__tab__wrapper" data-aos="fade-up">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <ul class="nav  course__tap__wrap" id="myTab" role="tablist">

                                            <li class="nav-item" role="presentation">
                                                <button class="single__tab__link" data-bs-toggle="tab"
                                                    data-bs-target="#projects__two" type="button"><i
                                                        class="icofont-calendar"></i>Time Table</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="single__tab__link active" data-bs-toggle="tab"
                                                    data-bs-target="#projects__one" type="button"><i
                                                        class="icofont-paper"></i>Description</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="single__tab__link" data-bs-toggle="tab"
                                                    data-bs-target="#projects__three" type="button"><i
                                                        class="icofont-star"></i>Reviews</button>
                                            </li>



                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content tab__content__wrapper" id="myTabContent">
                                    <div class="tab-pane fade " id="projects__two" role="tabpanel"
                                        aria-labelledby="projects__two">

                                        <div class="accordion content__cirriculum__wrap" id="accordionExample">
                                            @forelse ($course->coursePaths as $path)
                                                @foreach ($path->lessons as $lesson)
                                                    <div class="accordion-item roundd">
                                                        <h2 class="accordion-header">
                                                            <button class="accordion-button" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#lesson{{ $lesson->id }}"
                                                                aria-expanded="false"
                                                                aria-controls="lesson{{ $lesson->id }}">
                                                                {{ $lesson->title }}
                                                                <span>{{ $lesson->order ?? '' }}</span>
                                                            </button>
                                                        </h2>
                                                        <div id="lesson{{ $lesson->id }}"
                                                            class="accordion-collapse collapse"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="video-container">
                                                                    @if ($lesson->video_url)
                                                                        <iframe src="{{ $lesson->video_url }}"
                                                                            frameborder="0" allowfullscreen></iframe>
                                                                    @else
                                                                        <p>No video available for this lesson.</p>
                                                                    @endif
                                                                </div>
                                                                <p>{{ $lesson->description }}</p>
                                                                @if ($lesson->resource_file)
                                                                    <a href="{{ asset('storage/' . $lesson->resource_file) }}"
                                                                        download>Download Resource</a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @empty
                                                <p>No lessons available for this course.</p>
                                            @endforelse


                                        </div>

                                    </div>

                                    <div class="tab-pane fade active show" id="projects__one" role="tabpanel"
                                        aria-labelledby="projects__one">
                                        <div class="experence__heading">
                                            <h5> Experience Description</h5>
                                        </div>
                                        <div class="experence__description">
                                            <p class="description__1">Lorem ipsum dolor sit amet, consectetur
                                                adipiscing elit. Curabitur vulputate vestibulum Phasellus rhoncus, dolor
                                                eget viverra pretium, dolor tellus aliquet nunc, vitae ultricies erat
                                                elit eu lacus. Vestibulum
                                                non justo consectetur, cursus ante, tincidunt sapien. Nulla quis diam
                                                sit amet turpis interdum accumsan quis nec enim. Vivamus faucibus ex sed
                                                nibh egestas elementum. Mauris et bibendum dui. Aenean consequat
                                                pulvinar luctus
                                            </p>
                                            <p class="description__2">We have covered many special events such as
                                                fireworks, fairs, parades, races, walks, awards ceremonies, fashion
                                                shows, sporting events, and even a memorial service.
                                            </p>
                                            <p class="description__3">
                                                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur
                                                vulputate vestibulum Phasellus rhoncus, dolor eget viverra pretium,
                                                dolor tellus aliquet nunc, vitae ultricies erat elit eu lacus.
                                                Vestibulum non justo consectetur, cursus ante, tincidunt
                                                sapien. Nulla quis diam sit amet turpis interdum accumsan quis nec enim.
                                                Vivamus faucibus ex sed nibh egestas elementum. Mauris et bibendum dui.
                                                Aenean consequat pulvinar luctus.</p>
                                        </div>

                                    </div>



                                    <div class="tab-pane fade" id="projects__three" role="tabpanel"
                                        aria-labelledby="projects__three">

                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="review__box">
                                                    <div class="review__number">5.0</div>
                                                    <div class="review__icon">
                                                        <i class="icofont-star"></i>
                                                        <i class="icofont-star"></i>
                                                        <i class="icofont-star"></i>
                                                        <i class="icofont-star"></i>
                                                        <i class="icofont-star"></i>
                                                    </div>
                                                    <span>(17 Reviews)</span>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 col--30">
                                                <div class="review__wrapper">

                                                    <div class="single__progress__bar">
                                                        <div class="rating__text">
                                                            5 <i class="icofont-star"></i>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 100%" aria-valuenow="100"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <span class="rating-value">10</span>
                                                    </div>

                                                    <div class="single__progress__bar">
                                                        <div class="rating__text">
                                                            4 <i class="icofont-star"></i>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 80%" aria-valuenow="80"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <span class="rating-value">5</span>
                                                    </div>

                                                    <div class="single__progress__bar">
                                                        <div class="rating__text">
                                                            3 <i class="icofont-star"></i>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 60%" aria-valuenow="60"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <span class="rating-value">3</span>
                                                    </div>

                                                    <div class="single__progress__bar">
                                                        <div class="rating__text">
                                                            2 <i class="icofont-star"></i>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 30%" aria-valuenow="30"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <span class="rating-value">2</span>
                                                    </div>

                                                    <div class="single__progress__bar">
                                                        <div class="rating__text">
                                                            1 <i class="icofont-star"></i>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                style="width: 10%" aria-valuenow="10"
                                                                aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <span class="rating-value">1</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="property__facts__feature property__facts__feature__2 ">
                                            <h4>Customer Reviews</h4>



                                            <ul class="property__comment">
                                                <li class="property__comment__list">
                                                    <div class="property__comment__img">
                                                        <img loading="lazy" src="img/teacher/teacher__2.png"
                                                            alt="Image">
                                                    </div>
                                                    <div class="property__comment__comment">
                                                        <h6><a href="#">Adam Smit</a></h6>
                                                        <div class="property__sidebar__icon">
                                                            <ul>
                                                                <li><i class="icofont-star"></i></li>
                                                                <li><i class="icofont-star"></i></li>
                                                                <li><i class="icofont-star"></i></li>
                                                                <li><i class="icofont-star"></i></li>
                                                                <li><i class="icofont-star"></i></li>
                                                            </ul>
                                                        </div>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                            Doloribus, omnis fugit corporis iste magnam ratione.</p>
                                                        <span class="property__comment__reply__btn">September 2,
                                                            2024</span>
                                                    </div>

                                                </li>
                                                <li class="property__comment__list">
                                                    <div class="property__comment__img">
                                                        <img loading="lazy" src="img/teacher/teacher__1.png"
                                                            alt="Image">
                                                    </div>
                                                    <div class="property__comment__comment">
                                                        <h6><a href="#">Adam Smit</a></h6>
                                                        <div class="property__sidebar__icon">
                                                            <ul>
                                                                <li><i class="icofont-star"></i></li>
                                                                <li><i class="icofont-star"></i></li>
                                                                <li><i class="icofont-star"></i></li>
                                                                <li><i class="icofont-star"></i></li>
                                                                <li><i class="icofont-star"></i></li>
                                                            </ul>
                                                        </div>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                            Doloribus, omnis fugit corporis iste magnam ratione.</p>
                                                        <span class="property__comment__reply__btn">September 2,
                                                            2024</span>
                                                    </div>

                                                </li>
                                                <li class="property__comment__list">
                                                    <div class="property__comment__img">
                                                        <img loading="lazy" src="img/teacher/teacher__3.png"
                                                            alt="Image">
                                                    </div>
                                                    <div class="property__comment__comment">
                                                        <h6><a href="#">Adam Smit</a></h6>
                                                        <div class="property__sidebar__icon">
                                                            <ul>
                                                                <li><i class="icofont-star"></i></li>
                                                                <li><i class="icofont-star"></i></li>
                                                                <li><i class="icofont-star"></i></li>
                                                                <li><i class="icofont-star"></i></li>
                                                                <li><i class="icofont-star"></i></li>
                                                            </ul>
                                                        </div>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                                            Doloribus, omnis fugit corporis iste magnam ratione.</p>
                                                        <span class="property__comment__reply__btn">September 2,
                                                            2024</span>
                                                    </div>

                                                </li>
                                            </ul>

                                        </div>



                                    </div>



                                </div>
                            </div>



                            <div class="blog__details__tag" data-aos="fade-up">
                                <ul>
                                    <li class="heading__tag">
                                        Tag
                                    </li>
                                    <li>
                                        <a href="#">Business</a>
                                    </li>
                                    <li>
                                        <a href="#">Design</a>
                                    </li>
                                    <li>
                                        <a href="#">apps</a>
                                    </li>
                                    <li>
                                        <a href="#">data</a>
                                    </li>
                                </ul>

                            </div>










                        </div>
                    </div>


                    <div class="col-xl-4 col-lg-4">
                        <div class="course__details__sidebar--2">
                            <div class="event__sidebar__wraper" data-aos="fade-up">


                                <div class="blogarae__img__2 course__details__img__2" data-aos="fade-up">
                                    <img loading="lazy" src="img/blog/blog_7.png" alt="blog">

                                    <div class="registerarea__content course__details__video">
                                        <div class="registerarea__video">
                                            <div class="video__pop__btn">
                                                <a class="video-btn"
                                                    href="https://www.youtube.com/watch?v=vHdclsdkp28"> <img
                                                        loading="lazy" src="img/icon/video.png" alt=""></a>
                                            </div>


                                        </div>
                                    </div>
                                </div>


                                <div class="course__summery__button">
                                    <a class="default__button" href="#">Enroll Now</a>

                                </div>

                                <div class="course__summery__lists">
                                    <ul>
                                        <li>
                                            <div class="course__summery__item">
                                                <span class="sb_label">Instructor:</span><span class="sb_content"><a
                                                        href="instructor-details.html">D. Willaim</a></span>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="course__summery__item">
                                                <span class="sb_label">Start Date</span><span class="sb_content">05
                                                    Dec 2024</span>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="course__summery__item">
                                                <span class="sb_label">Total Duration</span><span
                                                    class="sb_content">08Hrs 32Min</span>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="course__summery__item">
                                                <span class="sb_label">Enrolled</span><span
                                                    class="sb_content">100</span>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="course__summery__item">
                                                <span class="sb_label">Lectures</span><span
                                                    class="sb_content">30</span>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="course__summery__item">
                                                <span class="sb_label">Skill Level</span><span
                                                    class="sb_content">Basic</span>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="course__summery__item">
                                                <span class="sb_label">Language</span><span
                                                    class="sb_content">Spanish</span>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="course__summery__item">
                                                <span class="sb_label">Quiz</span><span class="sb_content">Yes</span>
                                            </div>
                                        </li>

                                        <li>
                                            <div class="course__summery__item">
                                                <span class="sb_label">Certificate</span><span
                                                    class="sb_content">Yes</span>
                                            </div>
                                        </li>

                                    </ul>
                                </div>



                            </div>









                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer__section__start -->

        @include('include.footer')
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




</body>

</html>
