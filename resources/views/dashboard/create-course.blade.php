<!DOCTYPE html>
<html lang="zxx">
@include('include.head')

<main class="main_wrapper overflow-hidden">
    @include('include.dash-nav')

    <div class="breadcrumbarea">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="breadcrumb__content__wraper">
                        <div class="breadcrumb__title">
                            <h2 class="heading">Create Course</h2>
                        </div>
                        <div class="breadcrumb__inner">
                            <ul>
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li>Create Course</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Course Creation Form -->
    <div class="create__course sp_100">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <div class="create__course__accordion__wraper">
                        <div class="accordion" id="accordionExample">

                            <!-- Course Info -->
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Course Info
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show">
                                    <form action="{{ route('courses.store') }}" enctype="multipart/form-data" method="post">
                                        @csrf
                                        <div class="accordion-body">
                                            <div class="become__instructor__form">
                                                <div class="row">
                                                    <div class="col-xl-12 dashboard__form__input">
                                                        <label>Upload Course Cover</label>
                                                        <input class="form-control" type="file" name="image">
                                                    </div>
                                                    <div class="col-xl-6 dashboard__form__input">
                                                        <label>Course Title</label>
                                                        <input type="text" name="name" placeholder="Course Title" required>
                                                    </div>
                                                    <div class="col-xl-6 dashboard__form__input">
                                                        <label>Course Slug</label>
                                                        <input type="text" name="slug" placeholder="Course Slug" required>
                                                    </div>
                                                    
                                                    <div class="col-xl-6 dashboard__form__input">
                                                        <label>Price</label>
                                                        <input type="number" name="price" placeholder="Price" required>
                                                    </div>
                                                    <div class="col-xl-6 dashboard__form__input">
                                                        <label>Age Group</label>
                                                        @foreach(\App\Models\AgeGroup::all() as $age_group)
                                                        <select name="age_group" id="age_group">
                                                        <option value="{{$age_group->id }}">{{ $age_group->name }}</option>
                                                        </select>
                                                        @endforeach
                                                        {{-- <input type="number" name="age_group_id" placeholder="Age Group" required> --}}
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 dashboard__form__input">
                                                        <label>Language</label>
                                                        <select class="form-select" name="language">
                                                            <option value="English" selected>English</option>
                                                            <option value="Arabic">Arabic</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-xl-6 dashboard__form__input">
                                                        <label>Course Tags</label>
                                                        <input type="text" name="course_tags" placeholder="Tag1,Tag2,Tag3,etc">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12 dashboard__form__input">
                                                        <label>Description</label>
                                                        <textarea class="form-control" name="description" rows="4" required>Add your course benefits here.</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Course Paths Section -->
                                        <div class="accordion-body">
                                            <h4>Add Course Paths</h4>
                                            <div id="course-paths-container">
                                                <!-- Dynamic Course Paths will be added here -->
                                            </div>
                                            <button type="button" id="add-path-button" class="btn btn-secondary mt-3">+ Add Course Path</button>
                                        </div>

                                        <div class="col-xl-12 dashboard__form__input">
                                            <button type="submit" class="default__button">Save Course</button>
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

    @include('include.dash-footer')
@include('include.scripts')

</main>

<script>
let pathIndex = 0;

function addPath() {
    const container = document.getElementById('course-paths-container');

    const newPath = `
        <div class="course-path-item mt-4" id="course-path-${pathIndex}">
            <h5>Course Path ${pathIndex + 1}</h5>
            <div class="row">
                <div class="col-md-6">
                    <label>Path Name</label>
                    <input type="text" name="course_paths[${pathIndex}][name]" class="form-control" placeholder="Path Name" required>
                </div>
                <div class="col-md-6">
                    <label>Duration</label>
                    <input type="text" name="course_paths[${pathIndex}][duration]" class="form-control" placeholder="Duration" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label>Price</label>
                    <input type="number" step="0.01" name="course_paths[${pathIndex}][price]" class="form-control" placeholder="Price">
                </div>
                <div class="col-md-6">
                    <label>Description</label>
                    <textarea name="course_paths[${pathIndex}][description]" class="form-control" placeholder="Description"></textarea>
                </div>
            </div>
            <div>
                <h5>Sub Paths</h5>
                <div id="sub-paths-container-${pathIndex}"></div>
                <button type="button" class="btn btn-warning add-sub-path-btn" onclick="addSubPath(${pathIndex})">
                    + Add Sub-Path
                </button>
                <button type="button" class="btn btn-danger" onclick="removeElement('course-path-${pathIndex}')">
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
        <div class="sub-path-item mt-2" id="sub-path-${pathIndex}-${subPathIndex}">
            <div class="row">
                <div class="col-md-6">
                    <label>Sub Path Name</label>
                    <input type="text" name="path_of_paths[${pathIndex}][${subPathIndex}][name]" class="form-control" placeholder="Sub Path Name" required>
                </div>
                <div class="col-md-6">
                    <label>Sub Path Duration</label>
                    <input type="text" name="path_of_paths[${pathIndex}][${subPathIndex}][duration]" class="form-control" placeholder="Sub Path Duration">
                </div>
            </div>
            <button type="button" class="btn btn-danger mt-2" onclick="removeElement('sub-path-${pathIndex}-${subPathIndex}')">
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
