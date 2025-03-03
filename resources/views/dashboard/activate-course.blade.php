<!doctype html>
<html class="no-js" lang="zxx">
@include('include.head')

<head>
    @include('include.head')


</head>


<body class="body__wrapper">

    @include('include.load')


    <main class="main_wrapper overflow-hidden">

        <!-- headar section start -->
        @include('include.dash-nav')

        <!-- headar section end -->
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
                                <h2 class="heading">Create Course</h2>
                            </div>
                            <div class="breadcrumb__inner">
                                <ul>
                                    <li><a href="index.html">Home</a></li>
                                    <li>Create Course</li>
                                </ul>
                            </div>
                        </div>



                    </div>
                </div>
            </div>

            <div class="shape__icon__2">
                <img loading="lazy" class=" shape__icon__img shape__icon__img__1"
                    src="{{ asset('img/herobanner/herobanner__1.png') }}" alt="photo">
                <img loading="lazy" class=" shape__icon__img shape__icon__img__2"
                    src="{{ asset('img/herobanner/herobanner__2.png') }}" alt="photo">
                <img loading="lazy" class=" shape__icon__img shape__icon__img__3"
                    src="{{ asset('img/herobanner/herobanner__3.png') }}" alt="photo">
                <img loading="lazy" class=" shape__icon__img shape__icon__img__4"
                    src="{{ asset('img/herobanner/herobanner__5.png') }}" alt="photo">
            </div>

        </div>
        <!-- breadcrumbarea__section__end-->


        <!-- become__instructor__start -->
        <div class="create__course sp_100">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                        <div class="create__course__accordion__wraper">
                            <div class="accordion" id="accordionExample">

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            Course Info
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="become__instructor__form">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">

                                                        <label>Instructor</label>

                                                        <div class="dashboard__selector">

                                                            <select class="form-select"
                                                                aria-label="Default select example">
                                                                <option selected>All</option>
                                                                <option value="1">Web Design</option>
                                                                <option value="2">Graphic</option>

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">
                                                                <label for="#">Start Date</label>
                                                                <input type="date" placeholder="start date">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <div class="dashboard__form__wraper">
                                                            <label>Duration</label>
                                                            <div class="dashboard__selector">
                                                                <select class="form-select"
                                                                    aria-label="Default select example">
                                                                    <option selected>All</option>
                                                                    <option value="1">Web Design</option>
                                                                    <option value="2">Graphic</option>

                                                                </select>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">
                                                                <label for="#">Lectures</label>
                                                                <input type="text" placeholder="number of lectures">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row ">

                                                    <div class="dashboard__form__input">
                                                        <label>Time Table</label>
                                                        <input type="date" placeholder="date of lectures">
                                                    </div>


                                                </div>





                                                <div class="row ">





                                                    <div class="col-xl-12">
                                                        <div class="dashboard__form__button">
                                                            <a class="default__button" href="#">Activate the
                                                                course
                                                                now</a>
                                                        </div>
                                                    </div>




                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                            Course Info
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="become__instructor__form">
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">
                                                                <label for="#">Course Title</label>
                                                                <input type="text" placeholder="Course Title">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">
                                                                <label for="#">Course Slug</label>
                                                                <input type="text" placeholder="Course Slug">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">
                                                                <label for="#"> Price ($)</label>
                                                                <input type="text" placeholder=" Price ($)">
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">
                                                                <label for="#">Discounted Price ($)</label>
                                                                <input type="text"
                                                                    placeholder="Discounted Price ($)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row ">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">

                                                        <label>Course Path</label>

                                                        <div class="dashboard__selector">
                                                            <select class="form-select"
                                                                aria-label="Default select example">
                                                                <option selected>All</option>
                                                                <option value="1">Web Design</option>
                                                                <option value="2">Graphic</option>
                                                                <option value="3">English</option>
                                                                <option value="4">Spoken English</option>
                                                                <option value="5">Art Painting</option>
                                                                <option value="6">App Development</option>
                                                                <option value="7">Web Application</option>
                                                                <option value="7">Php Development</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">

                                                        <label>Choose age group</label>

                                                        <div class="dashboard__selector">
                                                            <select class="form-select"
                                                                aria-label="Default select example">
                                                                <option selected>6-8</option>
                                                                <option value="1">9-12</option>
                                                                <option value="2">13-17</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row sp_top_20">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">

                                                        <label>Skill Level</label>

                                                        <div class="dashboard__selector">
                                                            <select class="form-select"
                                                                aria-label="Default select example">
                                                                <option selected>1</option>
                                                                <option value="1">2</option>
                                                                <option value="2">3</option>

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <div class="dashboard__select__heading">
                                                            <label>Language</label>
                                                        </div>
                                                        <div class="dashboard__selector">
                                                            <select class="form-select"
                                                                aria-label="Default select example">
                                                                <option selected>English</option>
                                                                <option value="1">Arabic</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row sp_top_20">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <div class="dashboard__select__heading">
                                                            <label>prerequisites</label>
                                                        </div>
                                                        <div class="dashboard__selector">
                                                            <select class="form-select"
                                                                aria-label="Default select example">
                                                                <option selected>python</option>
                                                                <option value="1">java</option>
                                                                <option value="2">php</option>

                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <div class="dashboard__select__heading">
                                                            <label>Course Tags</label>
                                                        </div>
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">

                                                                <input type="text"
                                                                    placeholder="Tag1,Tag2,Tag3,etc">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row ">




                                                    <div class="col-xl-12">
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">
                                                                <label for="#">Description</label>
                                                                <textarea class="create__course__textarea" name="" id="" cols="30" rows="10">Add your course benefits here.</textarea>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12">
                                                        <div class="dashboard__form__button">
                                                            <a class="default__button" href="#">Save</a>
                                                        </div>
                                                    </div>




                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                            aria-expanded="false" aria-controls="collapseTwo">
                                            Course Media
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="become__instructor__form">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">
                                                                <div class="mb-3">
                                                                    <label for="formFile" class="form-label">Upload
                                                                        course
                                                                        cover</label>
                                                                    <input class="form-control" type="file"
                                                                        id="formFile">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12">
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">
                                                                <label for="#">Add course intro Video
                                                                    URL</label>
                                                                <input type="text"
                                                                    placeholder="Add your Video URL here">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <small>Example: <a
                                                            href="https://www.youtube.com/watch?v=yourvideoid">https://www.youtube.com/watch?v=yourvideoid</a></small>


                                                    <div class="col-xl-12">
                                                        <div class="dashboard__form__button">
                                                            <a class="default__button" href="#">Save</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                            aria-expanded="true" aria-controls="collapseThree">
                                            Course sessions
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <div class="row ">
                                                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                    <div class="dashboard__select__heading">
                                                        <label>session Number</label>
                                                    </div>
                                                    <div class="dashboard__form__wraper">
                                                        <div class="dashboard__form__input">

                                                            <input type="text" placeholder="ex:1">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                    <div class="dashboard__select__heading">
                                                        <label>Lesson Title</label>
                                                    </div>
                                                    <div class="dashboard__form__wraper">
                                                        <div class="dashboard__form__input">

                                                            <input type="text" placeholder="Lesson Title<">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                    <div class="dashboard__form__wraper">
                                                        <div class="dashboard__form__input">
                                                            <div class="mb-3">
                                                                <label for="formFile" class="form-label">Upload lesson
                                                                    materials</label>
                                                                <input class="form-control" type="file"
                                                                    id="formFile">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>


                                            <div class="create__course__button">
                                                <a class="default__button" href="#">Add New session</a>
                                            </div>

                                            <div class="row">
                                                <div class="col-xl-8 col-lg-12 col-md-12 col-sm-12 col-12"
                                                    data-aos="fade-up">

                                                    <div class="accordion content__cirriculum__wrap"
                                                        id="accordionExample">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="headingsession">
                                                                <button class="accordion-button" type="button"
                                                                    data-bs-toggle="collapse"
                                                                    data-bs-target="#collapsesession"
                                                                    aria-expanded="true"
                                                                    aria-controls="collapsesession">
                                                                    Lesson #01
                                                                </button>
                                                                <div class="scc__meta">

                                                                    <a href="lesson-2.html"><span
                                                                            class="question btn-danger"><i
                                                                                class="icofont-trash">Delete this
                                                                                session</i> </span></a>

                                                                </div>
                                                            </h2>
                                                            <div id="collapseOne"
                                                                class="accordion-collapse collapse show"
                                                                aria-labelledby="headingOne"
                                                                data-bs-parent="#accordionExample">
                                                                <div class="accordion-body">
                                                                    <div class="scc__wrap">
                                                                        <div class="scc__info">
                                                                            <i class="icofont-file-text"></i>
                                                                            <h5> <a href="#"
                                                                                    target="_blank"><span>Course
                                                                                        Materials</span></a></h5>
                                                                        </div>
                                                                        <div class="scc__meta">

                                                                            <a href="lesson-2.html"><span
                                                                                    class="question"><i
                                                                                        class="icofont-edit"></i>
                                                                                </span></a>

                                                                        </div>
                                                                    </div>


                                                                </div>

                                                            </div>
                                                        </div>





                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>



                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingFive">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseFive"
                                            aria-expanded="true" aria-controls="collapseFive">
                                            Certificate Template
                                        </button>
                                    </h2>
                                    <div id="collapseFive" class="accordion-collapse collapse"
                                        aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                                    <div class="create__course__single__img">
                                                        <img loading="lazy"
                                                            src="{{ asset('img/dashbord/dashbord__8.jpg') }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                                    <div class="create__course__single__img">
                                                        <img loading="lazy"
                                                            src="{{ asset('img/dashbord/dashbord__4.jpg') }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                                    <div class="create__course__single__img">
                                                        <img loading="lazy"
                                                            src="{{ asset('img/dashbord/dashbord__5.jpg') }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                                    <div class="create__course__single__img">
                                                        <img loading="lazy"
                                                            src="{{ asset('img/dashbord/dashbord__9.jpg') }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                                    <div class="create__course__single__img">
                                                        <img loading="lazy"
                                                            src="{{ asset('img/dashbord/dashbord__7.jpg') }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                                    <div class="create__course__single__img">
                                                        <img loading="lazy"
                                                            src="{{ asset('img/dashbord/dashbord__8.jpg') }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                                <div class="create__course__bottom__button">
                                    <a href="#">Create New Course</a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>



        <!-- become__instructor__end -->
        <!-- footer__section__start -->
        
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
