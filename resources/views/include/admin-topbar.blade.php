<div class="container-fluid full__width__padding">
    <div class="row">
        <div class="col-xl-12">
            <div class="dashboardarea__wraper">
                <div class="dashboardarea__img">
                    <div class="dashboardarea__inner student__dashboard__inner">
                        <div class="dashboardarea__left">
                            <div class="dashboardarea__left__img">
                                <img loading="lazy" src="{{ Auth::guard('admin')->user()->photo ? asset('student_photos/' . Auth::guard('student')->user()->photo) : asset('img/dashbord/dashbord__2.jpg') }}" alt="User Photo">


                            </div>
                            <div class="dashboardarea__left__content">
                                {{-- <h4>{{ $student->name }}</h4> --}}
                                <h4>{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</h4>
                            </div>
                            @if(Auth::guard('admin')->user()->roles[0]->name == 'admin')
                                        <div class="dashboardarea__right">
                                            <div class="dashboardarea__right__button">
                                                <a class="default__button" href="{{route('courses.create')}}">Create a New Course
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-arrow-right">
                                                        <line x1="5" y1="12" x2="19" y2="12">
                                                        </line>
                                                        <polyline points="12 5 19 12 12 19"></polyline>
                                                    </svg></a>
                                            </div>
                                        </div>
    @endif
                        </div>
                        
                        {{-- <div class="dashboardarea__right">
                            <div class="dashboardarea__right__button">
                                <a class="default__button" href="{{ route('courses.all') }}">Enroll A New
                                    Course
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-arrow-right">
                                        <line x1="5" y1="12" x2="19" y2="12">
                                        </line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg></a>
                            </div>
                        </div> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
