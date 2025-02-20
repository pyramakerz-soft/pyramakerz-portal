<!doctype html>
<html class="no-js" lang="zxx">
@include('include.head')
<style>
    .form-label {
        font-weight: bold;
        color: #333;
    }

    .border {
        border: 2px solid #dee2e6 !important;
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>
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
            <img loading="lazy" class=" shape__icon__img shape__icon__img__1" src="../img/herobanner/herobanner__1.png"
                alt="photo">
            <img loading="lazy" class=" shape__icon__img shape__icon__img__2" src="../img/herobanner/herobanner__2.png"
                alt="photo">
            <img loading="lazy" class=" shape__icon__img shape__icon__img__3" src="../img/herobanner/herobanner__3.png"
                alt="photo">
            <img loading="lazy" class=" shape__icon__img shape__icon__img__4" src="../img/herobanner/herobanner__5.png"
                alt="photo">
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
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success!</strong> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif


                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Course Info
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <form action="{{ route('courses.store') }}" enctype="multipart/form-data"
                                        method="post">
                                        @csrf
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
                                                                        name="image" id="formFile">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">
                                                                <label for="#">Course Title</label>
                                                                <input type="text" name="name"
                                                                    placeholder="Course Title">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">
                                                                <label for="#">Course Slug</label>
                                                                <input type="text" name="slug"
                                                                    placeholder="Course Slug">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">

                                                        <label>Course Path</label>

                                                        <div class="dashboard__selector">
                                                            <select class="form-select" name="course_path"
                                                                aria-label="Default select example">
                                                                {{-- <option selected>All</option> --}}
                                                                <option value="Web Development">Web Development
                                                                </option>
                                                                <option value="Game Development">Game Development
                                                                </option>
                                                                <option value="Mobile App Development">Mobile App
                                                                    Development</option>
                                                                <option value="Robotics Design">Robotics Design
                                                                </option>
                                                                <option value="Soft Skills">Soft Skills</option>
                                                                <option value="Aritifacial Intelligence">Aritifacial
                                                                    Intelligence</option>
                                                                <option value="Freelancing">Freelancing</option>
                                                                <option value="Graphic Desgin">Graphic Desgin</option>
                                                                <option value="cyber security">cyber security</option>
                                                                <option value="Business">Business</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <div class="dashboard__select__heading">
                                                            <label>Language</label>
                                                        </div>
                                                        <div class="dashboard__selector">
                                                            <select class="form-select" name="language"
                                                                aria-label="Default select example">
                                                                <option selected value="English">English</option>
                                                                <option value="Arabic">Arabic</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row sp_top_20">
                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <div class="dashboard__select__heading">
                                                            <label>Prerequisites</label>
                                                        </div>
                                                        <div class="dashboard__selector">
                                                            <select class="form-select" name="prereq[]" multiple
                                                                aria-label="Default select example">
                                                                <option value="python">Python</option>
                                                                <option value="java">Java</option>
                                                                <option value="php">PHP</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                        <div class="dashboard__select__heading">
                                                            <label>Course Tags</label>
                                                        </div>
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">

                                                                <input type="text" name="course_tags"
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
                                                                <textarea class="create__course__textarea" name="description" id="" cols="30" rows="10">Add your course benefits here.</textarea>

                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="accordion-body">
                                                        <div class="dashboard__form__wraper">
                                                            <h4>Add Course Paths</h4>
                                                            <div id="course-paths-container">
                                                                <div class="course-path-item mt-4">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label for="path_name">Path Name</label>
                                                                            <input type="text"
                                                                                name="course_paths[${pathIndex}][name]"
                                                                                placeholder="Path Name"
                                                                                class="form-control">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label for="path_duration">Duration</label>
                                                                            <input type="text"
                                                                                name="course_paths[${pathIndex}][duration]"
                                                                                placeholder="Duration"
                                                                                class="form-control">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row sp_top_20">
                                                                        <div class="col-md-6">
                                                                            <label for="path_price">Price</label>
                                                                            <input type="number" step="0.01"
                                                                                name="course_paths[${pathIndex}][price]"
                                                                                placeholder="Price"
                                                                                class="form-control">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label
                                                                                for="path_description">Description</label>
                                                                            <textarea name="course_paths[${pathIndex}][description]" class="form-control" placeholder="Description"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row sp_top_20">
                                                                        <div class="col-md-12">
                                                                            <label for="path_image">Path Image</label>
                                                                            <input type="file"
                                                                                name="course_paths[${pathIndex}][image]"
                                                                                class="form-control">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- <button type="button" id="add-path-button"
                                                                class="btn btn-secondary mt-3">Add Another
                                                                Path</button> --}}
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-12">
                                                        <div class="dashboard__form__button">
                                                            <button type="submit"
                                                                class="default__button">Save</button>
                                                            {{-- <input type="submit" 
                                                                value="Save"> --}}
                                                        </div>
                                                    </div>




                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        {{-- <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Course Media
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="become__instructor__form">
                                        <div class="row">


                                            <div class="col-xl-12">
                                                <div class="dashboard__form__wraper">
                                                    <div class="dashboard__form__input">
                                                        <label for="#">Add course intro Video URL</label>
                                                        <input type="text" placeholder="Add your Video URL here">
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
                        </div> --}}




                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingLessons">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseLessons" aria-expanded="true"
                                    aria-controls="collapseLessons">
                                    Create Lesson
                                </button>
                            </h2>
                            <div id="collapseLessons" class="accordion-collapse collapse"
                                aria-labelledby="headingLessons">
                                <div class="accordion-body">
                                    <div class="become__instructor__form">
                                        <div class="row">

                                            <form action="{{ route('lessons.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row g-4">
                                                    <!-- Select Course Path -->
                                                    <div class="col-md-6">
                                                        <label for="course_path_id" class="form-label">Select Course
                                                            Path</label>
                                                        <select name="course_path_id" id="course_path_id"
                                                            class="form-select" required>
                                                            <option value="" disabled selected>Select a Course
                                                                Path
                                                            </option>
                                                            @foreach ($coursePaths as $path)
                                                                <option value="{{ $path->id }}">{{ $path->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Lesson Title -->
                                                    <div class="col-md-6">
                                                        <label for="title" class="form-label">Lesson Title</label>
                                                        <input type="text" name="title" id="title"
                                                            class="form-control" placeholder="Enter Lesson Title"
                                                            required>
                                                    </div>

                                                    <!-- Lesson Description -->
                                                    <div class="col-md-12">
                                                        <label for="description"
                                                            class="form-label">Description</label>
                                                        <textarea name="description" id="description" class="form-control" rows="4"
                                                            placeholder="Add a brief description"></textarea>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="video_url" class="form-label">Video URL</label>
                                                        <input type="url" name="video_url" id="video_url"
                                                            class="form-control" placeholder="Enter Video URL">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="resource_file" class="form-label">Upload Resource
                                                            File</label>
                                                        <input type="file" name="resource_file" id="resource_file"
                                                            class="form-control">
                                                        <small class="text-muted">Accepted formats: PDF, DOCX, ZIP
                                                            (Max:
                                                            2MB)</small>
                                                    </div>

                                                    <!-- Lesson Order -->
                                                    {{-- <div class="col-md-6">
                                                <label for="order" class="form-label">Order</label>
                                                <input type="number" name="order" id="order"
                                                    class="form-control" placeholder="Enter Lesson Order">
                                            </div> --}}

                                                    <!-- Is Active -->
                                                    <div class="col-md-6">
                                                        <label for="is_active" class="form-label">Active</label>
                                                        <select name="is_active" id="is_active" class="form-select">
                                                            <option value="1" selected>Yes</option>
                                                            <option value="0">No</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Dynamic Lesson Addition -->
                                                <div id="lessons-container" class="mt-4"></div>
                                                <button type="button" id="add-lesson-btn"
                                                    class="btn btn-secondary mt-3">
                                                    <i class="bi bi-plus-circle"></i> Add New Lesson
                                                </button>

                                                <!-- Submit Button -->
                                                <div class="mt-4">
                                                    <button type="submit" class="btn btn-black">Add Lesson</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                                    Certificate Template
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="row">
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                            <div class="create__course__single__img">
                                                <img loading="lazy" src="../img/dashbord/dashbord__8.jpg"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                            <div class="create__course__single__img">
                                                <img loading="lazy" src="../img/dashbord/dashbord__4.jpg"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                            <div class="create__course__single__img">
                                                <img loading="lazy" src="../img/dashbord/dashbord__5.jpg"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                            <div class="create__course__single__img">
                                                <img loading="lazy" src="../img/dashbord/dashbord__9.jpg"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                            <div class="create__course__single__img">
                                                <img loading="lazy" src="../img/dashbord/dashbord__7.jpg"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                            <div class="create__course__single__img">
                                                <img loading="lazy" src="../img/dashbord/dashbord__8.jpg"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-6 col-12">
                            <div class="create__course__bottom__button">
                                <a href="#">Create New Course</a>
                            </div>
                        </div>

                    </div> --}}
            </div>

        </div>
    </div>
    </div>



    <!-- become__instructor__end -->
    <!-- footer__section__start -->
    @include('include.dash-footer')
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
{{-- <script>
    let pathIndex = 1;
    document.getElementById('add-path-button').addEventListener('click', () => {
        const container = document.getElementById('course-paths-container');
        const newPath = `
        <div class="course-path-item mt-4">
            <div class="row">
                <div class="col-md-6">
                    <label for="path_name">Path Name</label>
                    <input type="text" name="course_paths[${pathIndex}][name]" placeholder="Path Name" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="path_duration">Duration</label>
                    <input type="text" name="course_paths[${pathIndex}][duration]" placeholder="Duration" class="form-control">
                </div>
            </div>
            <div class="row sp_top_20">
                <div class="col-md-6">
                    <label for="path_price">Price</label>
                    <input type="number" step="0.01" name="course_paths[${pathIndex}][price]" placeholder="Price" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="path_description">Description</label>
                    <textarea name="course_paths[${pathIndex}][description]" class="form-control" placeholder="Description"></textarea>
                </div>
                <div class="row sp_top_20">
                                                                        <div class="col-md-12">
                                                                            <label for="path_image">Path Image</label>
                                                                            <input type="file"
                                                                                name="course_paths[${pathIndex}][image]"
                                                                                class="form-control">
                                                                        </div>
                                                                    </div>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', newPath);
        pathIndex++;
    });
</script> --}}
<script>
    let lessonIndex = 0;

    document.getElementById('add-lesson-btn').addEventListener('click', () => {
        const container = document.getElementById('lessons-container');
        const lessonForm = `
        <div class="lesson-form mt-4">
            <div class="row">
                <div class="col-md-6">
                    <label>Lesson Title</label>
                    <input type="text" name="lessons[${lessonIndex}][title]" class="form-control" placeholder="Lesson Title">
                </div>
                
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <label>Description</label>
                    <textarea name="lessons[${lessonIndex}][description]" class="form-control" rows="4"></textarea>
                </div>
            </div>
            <div class="row">

<div class="col-md-6">
                                                        <label for="video_url" class="form-label">Video URL</label>
                                                        <input type="url" name="lessons[${lessonIndex}][video_url]" id="video_url"
                                                            class="form-control" placeholder="Enter Video URL">
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label for="resource_file" class="form-label">Upload Resource
                                                            File</label>
                                                        <input type="file" name="lessons[${lessonIndex}][resource_file]" id="resource_file"
                                                            class="form-control">
                                                        <small class="text-muted">Accepted formats: PDF, DOCX, ZIP
                                                            (Max:
                                                            2MB)</small>
                                                    </div>
                </div
        </div>`;
        container.insertAdjacentHTML('beforeend', lessonForm);
        lessonIndex++;
    });
</script>



</body>

</html>
