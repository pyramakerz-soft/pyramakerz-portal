<!DOCTYPE html>
<html lang="zxx">
@include('include.head')
@include('include.load')

<main class="main_wrapper overflow-hidden">
    @include('include.dash-nav')

    <div class="container-fluid full__width__padding py-4">
        <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-12">
                @include('include.sidebar')
            </div>

            <div class="col-xl-9 col-lg-9 col-md-12">
                <div class="row mb-4">
                    <div class="col-xl-12">
                        <div class="breadcrumb__content__wraper">
                            <div class="breadcrumb__title">
                                <h2 class="heading">Create Course</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Course Creation Form -->
                <div class="create__course rounded shadow-sm">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="create__course__accordion__wraper">
                                <div class="accordion" id="accordionExample">

                                    @if($errors->any())
                                    <div class="alert alert-danger">
                                        <strong>Please fix the following errors:</strong>
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif

                                    <!-- Course Info -->
                                    <div class="accordion-item">
                                        <div id="collapseOne" class="accordion-collapse collapse show">
                                            <form action="{{ route('courses.store') }}" enctype="multipart/form-data" method="post">
                                                @csrf

                                                <div class="accordion-body">
                                                    <div class="become__instructor__form">
                                                        <div class="row g-3">
                                                            <div class="col-xl-12 dashboard__form__input">
                                                                <label class="form-label fw-bold">Upload Course Cover</label>
                                                                <input class="form-control" type="file" name="image">
                                                            </div>
                                                            <div class="col-xl-6 dashboard__form__input">
                                                                <label class="form-label fw-bold">Course Title</label>
                                                                <input type="text" name="name" class="form-control" placeholder="Course Title" required>
                                                            </div>
                                                            <div class="col-xl-6 dashboard__form__input">
                                                                <label class="form-label fw-bold">Course Slug</label>
                                                                <input type="text" name="slug" class="form-control" placeholder="Course Slug" required>
                                                            </div>
                                                            <div class="col-xl-6 dashboard__form__input">
                                                                <label class="form-label fw-bold">Price</label>
                                                                <input type="number" name="price" class="form-control" min="0" placeholder="Price" required>
                                                            </div>
                                                            <div class="col-xl-6 dashboard__form__input">
                                                                <label class="form-label fw-bold">Age Group</label>
                                                                <select name="age_group_id" class="form-select" required>
                                                                    <option value="">Select Age Group</option>
                                                                    @foreach($age_groups as $age_group)
                                                                    <option value="{{$age_group->id }}">{{ $age_group->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-xl-6 dashboard__form__input">
                                                                <label class="form-label fw-bold">Language</label>
                                                                <select class="form-select" name="language">
                                                                    <option value="English" selected>English</option>
                                                                    <option value="Arabic">Arabic</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-xl-6 dashboard__form__input">
                                                                <label class="form-label fw-bold">Course Tags</label>
                                                                <input type="text" name="course_tags" class="form-control" placeholder="Tag1,Tag2,Tag3,etc">
                                                            </div>
                                                            <div class="col-xl-12 dashboard__form__input">
                                                                <label class="form-label fw-bold">Description</label>
                                                                <textarea class="form-control" name="description" rows="4" required>Add your course benefits here.</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Course Paths Section -->
                                                <div class="accordion-body border-top mt-4 pt-4">
                                                    <h4 class="fw-bold mb-3">Add Course Paths</h4>
                                                    <div id="course-paths-container">
                                                        <!-- Dynamic Course Paths will be added here -->
                                                    </div>
                                                    <button type="button" id="add-path-button" class="btn btn-outline-primary mt-3">+ Add Course Path</button>
                                                </div>

                                                <div class="mt-4">
                                                    <button type="submit" class="btn btn-success w-100 py-2 fw-bold">Save Course</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div> <!-- /accordion-item -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- /create course -->

            </div> <!-- /col-xl-9 -->
        </div>
    </div>

    @include('include.scripts')
</main>

<script>
    let pathIndex = 0;

    function addPath() {
        const container = document.getElementById('course-paths-container');

        const newPath = `
        <div class="course-path-item mt-4 p-3 become__instructor__form" id="course-path-${pathIndex}">
            <h5 class="fw-bold">Course Path ${pathIndex + 1}</h5>
            <div class="row g-3">
                <div class="col-md-6 dashboard__form__input">
                    <label class="form-label">Path Name</label>
                    <input type="text" name="course_paths[${pathIndex}][name]" class="form-control" placeholder="Path Name" required>
                </div>
                <div class="col-md-6 dashboard__form__input">
                    <label class="form-label">Duration (Hours)</label>
                    <input type="number" name="course_paths[${pathIndex}][duration]" class="form-control" placeholder="Duration" required>
                </div>
                <div class="col-md-6 dashboard__form__input">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" min="0" name="course_paths[${pathIndex}][price]" class="form-control" placeholder="Price">
                </div>
                <div class="col-md-6 dashboard__form__input">
                    <label class="form-label">Description</label>
                    <textarea name="course_paths[${pathIndex}][description]" class="form-control" placeholder="Description"></textarea>
                </div>
            </div>
            <div class="mt-3">
                <h6 class="fw-bold">Sub Paths</h6>
                <div id="sub-paths-container-${pathIndex}"></div>
                <button type="button" class="btn btn-outline-warning mt-2 me-2" onclick="addSubPath(${pathIndex})">
                    + Add Sub-Path
                </button>
                <button type="button" class="btn btn-outline-danger mt-2" onclick="removeElement('course-path-${pathIndex}')">
                    Remove Path
                </button>
            </div>
        </div>`;
        container.insertAdjacentHTML('beforeend', newPath);
        pathIndex++;
    }

    function addSubPath(pathIndex) {
        let subPathContainer = document.getElementById(`sub-paths-container-${pathIndex}`);
        let subPathIndex = subPathContainer.querySelectorAll('.sub-path-item').length;

        const subPath = `
        <div class="sub-path-item mt-3 p-2 become__instructor__form" id="sub-path-${pathIndex}-${subPathIndex}">
            <div class="row g-3">
                <div class="col-md-6 dashboard__form__input">
                    <label class="form-label">Sub Path Name</label>
                    <input type="text" name="path_of_paths[${pathIndex}][${subPathIndex}][name]" class="form-control" placeholder="Sub Path Name" required>
                </div>
                <div class="col-md-6 dashboard__form__input">
                    <label class="form-label">Sub Path Duration (Hours)</label>
                    <input type="number" name="path_of_paths[${pathIndex}][${subPathIndex}][duration]" class="form-control" placeholder="Sub Path Duration">
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="removeElement('sub-path-${pathIndex}-${subPathIndex}')">
                Remove Sub-Path
            </button>
        </div>`;
        subPathContainer.insertAdjacentHTML('beforeend', subPath);
    }

    function removeElement(elementId) {
        document.getElementById(elementId).remove();
    }

    document.getElementById('add-path-button').addEventListener('click', addPath);
</script>

</body>

</html>