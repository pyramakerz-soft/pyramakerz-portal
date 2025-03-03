
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="container-fluid full__width__padding">
    <div class="row">
        <div class="col-xl-12">
            <div class="dashboardarea__wraper">
                <div class="dashboardarea__img">
                    <div class="dashboardarea__inner student__dashboard__inner">
                        <div class="dashboardarea__left">
                            <div class="dashboardarea__left__img">
                                <img loading="lazy"
                                    src="{{ Auth::guard('student')->user() ? asset('student_photos/' . Auth::guard('student')->user()->photo) : asset('student_photos/17348674791579649013569.jpg') }}"
                                    alt="User Photo">


                            </div>
                            <div class="dashboardarea__left__content">
                                {{-- <h4>{{ $student->name }}</h4> --}}
                                <h4>{{ Auth::guard('student')->user() ? Auth::guard('student')->user()->name : 'Student' }}
                                </h4>
                                <ul>
                                    <li> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-book-open">
                                            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                                            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                                        </svg>
                                        9 Completed Courses
                                    </li>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-award">
                                            <circle cx="12" cy="8" r="7"></circle>
                                            <polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88">
                                            </polyline>
                                        </svg>
                                        8 Certificate
                                    </li>
                                </ul>

                            </div>
                        </div>
                        @if(Auth::guard('admin')->user())
                        @if(Auth::guard('admin')->user()->roles[0]->name != 'admin')
                        <div class="dashboardarea__right">
                            <div class="dashboardarea__right__button">
                                <a class="default__button" href="{{ route('student.join-now') }}">Join Now
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-arrow-right">
                                        <line x1="5" y1="12" x2="19" y2="12">
                                        </line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg></a>
                            </div>
                            <div class="dashboardarea__right__button">
                                <a class="default__button" href="{{ route('courses.all') }}">Send Ticket
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-arrow-right">
                                        <line x1="5" y1="12" x2="19" y2="12">
                                        </line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg></a>
                            </div>
                        </div>
                        @endif
                        @else
                        <div class="dashboardarea__right">
                            <div class="dashboardarea__right__button">
                                <a class="default__button" href="{{ route('student.join-now') }}">Join Now
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-arrow-right">
                                        <line x1="5" y1="12" x2="19" y2="12">
                                        </line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg></a>
                            </div>
                            <div class="dashboardarea__right__button">
                                <a class="default__button" href="{{ route('courses.all') }}">Send Ticket
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-arrow-right">
                                        <line x1="5" y1="12" x2="19" y2="12">
                                        </line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg></a>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.querySelector('.dashboardarea__right__button a[href="{{ route('courses.all') }}"]').addEventListener('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Send Ticket',
            html: `
                <select id="ticket-category" class="swal2-input">
                    <option value="">Select Category</option>
                    <option value="Technical">Technical</option>
                    <option value="Academic">Academic</option>
                    <option value="Other">Other</option>
                </select>
                <textarea id="ticket-message" class="swal2-textarea" placeholder="Enter your message"></textarea>
                <input type="file" id="ticket-attachment" class="swal2-file" />
            `,
            confirmButtonColor: '#ff7918',
            focusConfirm: false,
            preConfirm: () => {
                const category = Swal.getPopup().querySelector('#ticket-category').value;
                const message = Swal.getPopup().querySelector('#ticket-message').value;
                const attachment = Swal.getPopup().querySelector('#ticket-attachment').files[0];
    
                if (!category || !message) {
                    Swal.showValidationMessage(`Please select a category and provide a message`);
                }
                return { category, message, attachment };
            },
            showCancelButton: true,
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('category', result.value.category);
                formData.append('message', result.value.message);
                if (result.value.attachment) {
                    formData.append('attachment', result.value.attachment);
                }
                fetch('{{ route("ticket.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success!', data.message, 'success');
                    } else {
                        Swal.fire('Error!', 'There was an error submitting your ticket', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', 'There was an error submitting your ticket', 'error');
                });
            }
        });
    });
    </script>