<div class="dashboard__inner sticky-top">
    <div class="dashboard__nav__title">
        <h6>Welcome, {{ Auth::guard('admin')->user()->name ?? 'User' }}</h6>
    </div>
    <div class="dashboard__nav">
        <ul>

            <!-- STUDENT Sidebar -->
            @if(Auth::guard('admin')->user()->roles[0]->name == 'student')
            <li><a href="{{ route('my-progress') }}"><i class="feather feather-user"></i> My Progress</a></li>
            <li><a href="{{ route('student-courses') }}"><i class="feather feather-bookmark"></i> Enrolled Courses</a></li>
            <li><a href="{{ route('student-profile') }}"><i class="feather feather-user"></i> My Profile</a></li>
            <li><a href="{{ route('student-settings',Auth::guard('student')->user()->id) }}"><i class="feather feather-settings"></i> Settings</a></li>
            <li><a href="{{ route('logout') }}"><i class="feather feather-log-out"></i> Logout</a></li>
            @endif

            <!-- INSTRUCTOR Sidebar -->
            @if(Auth::guard('admin')->user()->roles[0]->name == 'instructor')
            <li><a href="{{ route('instructor.profile') }}"><i class="feather feather-user"></i> My Profile</a></li>
            <li><a href="{{ route('admin-courses') }}"><i class="feather feather-bookmark"></i> My Courses</a></li>
            <li><a href="{{ route('instructor.time-table') }}"><i class="feather feather-calendar"></i> My Calendar</a></li>
            <li><a href="{{ route('instructor.zoom_meetings') }}"><i class="feather feather-book-open"></i> Sessions</a></li>
            <!-- <li><a href="{{route('instructor-chat')}}"><i class="feather feather-message-circle"></i> Message</a></li> -->
            <li><a href="{{ route('admin-settings') }}"><i class="feather feather-settings"></i> Settings</a></li>
            <li><a href="{{ route('logout-admin') }}"><i class="feather feather-log-out"></i> Logout</a></li>
            @endif

            <!-- SUPERVISOR Sidebar -->
            @if(Auth::guard('admin')->user()->roles[0]->name == 'supervisor')

            <li><a href="{{ route('admin.instructors.index') }}"><i class="feather feather-users"></i> Instructors</a></li>
            <li><a href="{{ route('admin.students.index') }}"><i class="feather feather-users"></i> Students</a></li>
            <li><a href="{{ route('admin.lesson-resources.index') }}"><i class="feather feather-users"></i> Manage Lesson Resources</a></li>
            <li><a href="{{ route('admin.evaluations.index') }}"><i class="feather feather-bar-chart-2"></i> Evaluations</a></li>
            <li><a href="{{ route('admin.evaluations.manual') }}"><i class="feather feather-clipboard"></i> Manual Evaluations</a></li>
            <li><a href="{{ route('admin.track-progress.index') }}"><i class="feather feather-trending-up"></i> Track Progress</a></li>
            <li><a href="{{ route('admin.attendance.index') }}"><i class="feather feather-calendar"></i> Attendance</a></li>
            <li><a href="{{ route('admin.enrollment_requests') }}"><i class="feather feather-user-check"></i> Enrollment Requests</a></li>
            <li><a href="{{ route('admin.tickets') }}"><i class="feather feather-message-circle"></i> Tickets</a></li>
            <li><a href="{{ route('logout-admin') }}"><i class="feather feather-log-out"></i> Logout</a></li>
            @endif

            <!-- ADMIN Sidebar -->
            @if(Auth::guard('admin')->user()->roles[0]->name == 'admin')
            <li><a href="{{ route('admin-courses') }}">
                    <i class="feather feather-book" ...></i> All Courses
                </a>
            </li>
            <li><a href="{{ route('admin.instructors.index') }}"><i class="feather feather-users"></i> Manage Instructors</a></li>
            <li><a href="{{ route('admin.students.index') }}"><i class="feather feather-users"></i> Manage Students</a></li>
            <li><a href="{{ route('admin.lesson-resources.index') }}"><i class="feather feather-users"></i> Manage Lesson Resources</a></li>
            <li><a href="{{ route('admin.evaluations.index') }}"><i class="feather feather-bar-chart-2"></i> Evaluations</a></li>
            <li><a href="{{ route('admin.evaluations.manual') }}"><i class="feather feather-clipboard"></i> Manual Evaluations</a></li>
            <li><a href="{{ route('admin.track-progress.index') }}"><i class="feather feather-trending-up"></i> Track Progress</a></li>
            <li><a href="{{ route('admin.attendance.index') }}"><i class="feather feather-calendar"></i> Attendance</a></li>
            <li><a href="{{ route('admin.enrollment_requests') }}"><i class="feather feather-user-check"></i> Enrollment Requests</a></li>
            <li><a href="{{ route('admin.tickets') }}"><i class="feather feather-message-circle"></i> Tickets</a></li>
            {{-- <li><a href="{{ route('admin-settings') }}"><i class="feather feather-settings"></i> Settings</a></li> --}}
            <li><a href="{{ route('logout-admin') }}"><i class="feather feather-log-out"></i> Logout</a></li>
            @endif

        </ul>
    </div>
</div>