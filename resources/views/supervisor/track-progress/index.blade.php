<!doctype html>
<html class="no-js" lang="zxx">
@include('include.head')

<main class="main_wrapper overflow-hidden">
    @include('include.dash-nav')

    <!-- dashboardarea__area__start  -->
    <div class="dashboardarea ">
        @include('include.admin-topbar')
        <div class="dashboard">
            <div class="container-fluid full__width__padding">
                <div class="row">
                    <div class="col-xl-3 col-lg-3 col-md-12">
                        @include('include.supervisor-sidebar')

                    </div>
                    <div class="col-xl-9 col-lg-9 col-md-12">
                        <div class="dashboard__content__wraper">
                            <div class="dashboard__section__title">
                                <h4>Summary</h4>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy" src="../img/counter/counter__2.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <p class="counter"><strong>Total Groups:</strong>
                                                        {{ $totalGroups }}</p>
                                                    <br>
                                                    <p class="counter"><strong>Online Groups:</strong>
                                                        {{ $onlineGroups }}</p>
                                                    <br>
                                                    <p class="counter"><strong>Offline Groups:</strong>
                                                        {{ $offlineGroups }}</p>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy" src="../img/counter/counter__3.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    {{-- <span class="counter">12</span> --}}
                                                    <p class="counter"><strong>Delayed Groups:</strong>
                                                        {{ $delayedGroups }}</p>
                                                    <br>
                                                    <p class="counter"><strong>Finished Groups:</strong>
                                                        {{ $finishedGroups }}</p>
                                                    <br>
                                                    <p class="counter"><strong>Canceled Groups:</strong>
                                                        {{ $canceledGroups }}</p>
                                                </div>
                                                {{-- <p>Complete Lessons</p> --}}

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

    <!-- Summary Section -->

    <div class="dashboard">
        <div class="container-fluid full__width__padding">

            {{-- <div class="row mb-4">
                    <div class="col-lg-4">
                        <div class="summary-box">
                            <h5>📌 Daily Groups</h5>
                            <p><strong>Total Groups:</strong> {{ $totalGroups }}</p>
                            <p><strong>Online Groups:</strong> {{ $onlineGroups }}</p>
                            <p><strong>Offline Groups:</strong> {{ $offlineGroups }}</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="summary-box">
                            <h5>📊 Weekly Evaluation</h5>
                            <p><strong>Delayed Groups:</strong> {{ $delayedGroups }}</p>
                            <p><strong>Finished Groups:</strong> {{ $finishedGroups }}</p>
                            <p><strong>Canceled Groups:</strong> {{ $canceledGroups }}</p>
                        </div>
                    </div>
                </div> --}}

            <!-- Filters -->
            <div class="dashboard__content__wraper">
                <div class="dashboard__section__title">
                    <h4>📊 Track Progress</h4>
                </div>

                <form action="{{ route('admin.track-progress.index') }}" method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="branch" class="form-control">
                                <option value="">Select Branch</option>
                                <option value="Cairo">Cairo</option>
                                <option value="Alexandria">Alexandria</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="instructor_id" class="form-control">
                                <option value="">Select Instructor</option>
                                @foreach ($instructors as $instructor)
                                    <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="course_id" class="form-control">
                                <option value="">Select Course</option>
                                @foreach ($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <select name="status" class="form-control">
                                <option value="">Select Status</option>
                                <option value="Online">Online</option>
                                <option value="Offline">Offline</option>
                                <option value="Delayed">Delayed</option>
                                <option value="Finished">Finished</option>
                                <option value="Canceled">Canceled</option>
                            </select>
                        </div>

                        <div class="col-md-3 mt-2">
                            <button type="submit" class="btn btn-black w-100">Filter</button>
                        </div>
                    </div>
                </form>

                <!-- Progress Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="  headtb text-white">
                            <tr>
                                <th>Branch</th>
                                <th>Course Name</th>
                                <th>Age Group</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Instructor</th>
                                <th>Progress</th>
                                <th>Materials</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($progressData as $progress)
                                <tr>
                                    <td>{{ $progress->branch }}</td>
                                    <td>{{ $progress->course->name }}</td>
                                    <td>{{ $progress->age_group }}</td>
                                    <td>{{ $progress->start_time }} - {{ $progress->end_time }}</td>
                                    <td>{{ $progress->status }}</td>
                                    <td>{{ $progress->instructor->name }}</td>
                                    <td>{{ json_encode($progress->progress) }}</td>
                                    <td>{{ json_encode($progress->materials) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No Progress Data Found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    </div>
</main>

<!-- CSS for Summary Boxes -->
<style>
    .summary-box {
        background: orangered;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .summary-box h5 {
        margin-bottom: 10px;
        color: #333;
    }

    .summary-box p {
        margin: 5px 0;
        font-size: 14px;
    }
</style>

</html>
