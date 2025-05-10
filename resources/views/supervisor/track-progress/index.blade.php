<!doctype html>
<html class="no-js" lang="zxx">
@include('include.head')

<main class="main_wrapper overflow-hidden">
    @include('include.dash-nav')

    <!-- dashboardarea__area__start  -->
    <div class="dashboardarea ">
        @include('include.admin-topbar')
        {{-- <div class="dashboard"> --}}
        <div class="container-fluid full__width__padding">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-12">
                    @include('include.sidebar')

                </div>
                <div class="col-xl-9 col-lg-9 col-md-12">
                    <div class="dashboard__content__wraper">
                        <div class="dashboard__section__title">
                            <h4>Summary</h4>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 col-lg-6 col-md-12 col-12">
                                <div class="dashboard__single__counter">
                                    <div class="counterarea__text__wraper">
                                        <div class="counter__img">
                                            <img loading="lazy" src="{{asset('img/counter/counter__2.png')}}" alt="counter">
                                        </div>
                                        <div class="counter__content__wraper" style="flex-grow: 1;">
                                            <div class="counter__number" style="display: flex;justify-content: space-evenly;align-items: center;">
                                                <p class="counter"><strong>Total Groups:</strong>
                                                    {{ $totalGroups }}
                                                </p>
                                                <br>
                                                <p class="counter"><strong>Active Groups:</strong>
                                                    {{ $activeGroups }}
                                                </p>
                                                <br>
                                                <p class="counter"><strong>Unactive Groups:</strong>
                                                    {{ $unactiveGroups }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Filters -->
                    <div class="dashboard__content__wraper">
                        <div class="dashboard__section__title">
                            <h4>📊 Track Progress</h4>
                        </div>

                        <form action="{{ route('admin.track-progress.index') }}" method="GET" class="mb-4">
                            <div class="row">
                                <div class="col-md-3">
                                    <select name="instructor_id" class="form-control">
                                        <option value="">Select Instructor</option>
                                        @foreach ($instructors as $instructor)
                                        <option value="{{ $instructor->id }}" {{ request('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                            {{ $instructor->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <select name="course_id" class="form-control">
                                        <option value="">Select Course</option>
                                        @foreach ($courses as $course)
                                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                            {{ $course->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <select name="group_id" class="form-control">
                                        <option value="">Select Group</option>
                                        @foreach ($courses->flatMap->groups as $group)
                                        <option value="{{ $group->id }}" {{ request('group_id') == $group->id ? 'selected' : '' }}>
                                            {{ $group->name ?? 'Group #' . $group->id }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <select name="status" class="form-control">
                                        <option value="">Select Status</option>
                                        <option value="Online" {{ request('status') == 'Online' ? 'selected' : '' }}>Online</option>
                                        <option value="Finished" {{ request('status') == 'Finished' ? 'selected' : '' }}>Finished</option>
                                    </select>
                                </div>

                                <div class="col-md-3 mt-2">
                                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="form-control" placeholder="Start Date">
                                </div>

                                <div class="col-md-3 mt-2">
                                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="form-control" placeholder="End Date">
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
                                        <th>Course Name</th>
                                        <th>Group Name</th>
                                        <th>Instructor</th>
                                        <th>Total Sessions</th>
                                        <th>Completed Sessions</th>
                                        <th>Progess Percentage</th>
                                        <th>Status</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($progressData as $progress)
                                    <tr>
                                        <td>{{ $progress->course->name }}</td>
                                        <td>{{ $progress->group->name }}</td>
                                        <td>{{ $progress->instructor->name }}</td>
                                        <td>{{ $progress->total_sessions }}</td>
                                        <td>{{ $progress->completed_sessions }}</td>
                                        <td>{{ round(($progress->completed_sessions/$progress->total_sessions) * 100,2) }}%</td>
                                        <td>{{ $progress->status }}</td>
                                        <td>{{ $progress->start_date }}</td>
                                        <td>{{ $progress->end_date }}</td>
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