<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration & Programming</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
</head>

<body>
    <div id="app">
        <div class="floating-cloud cloud-1"></div>
        <div class="floating-star cloud-2"></div>
        <div class="floating-cloud cloud-3"></div>
        <div class="floating-star cloud-4"></div>

        <div id="registration-phase">
            <form id="registration-form" action="{{ route('register-student') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="step active" id="step-1">
                    <h2>👤 Personal Information</h2>
                    <label>
                        <span>Name:</span>
                        <input type="text" name="name" placeholder="Enter your name" required />
                    </label>
                    <label>
                        <span>Email:</span>
                        <input type="email" name="email" placeholder="Enter your email" required />
                    </label>
                    <label>
                        <span>Phone:</span>
                        <input type="tel" name="phone" placeholder="Enter your phone number" required />
                    </label>
                    <label>
                        <span>Password:</span>
                        <input type="password" name="password" placeholder="Create a password" required />
                    </label>
                </div>

                <!-- Step 2: Location -->
                <div class="step" id="step-2">
                    <h2>🌍 Location</h2>
                    <label>
                        <span>Country:</span>
                        <input type="text" name="country" placeholder="Enter your country" required />
                    </label>
                    <label>
                        <span>City:</span>
                        <input type="text" name="city" placeholder="Enter your city" required />
                    </label>
                    <label>
                        <span>School:</span>
                        <input type="text" name="school" placeholder="Enter your school" />
                    </label>
                    <div class="form-navigation">
                        <button type="button" class="fun-btn back-btn" onclick="prevStep()">⬅️ Back</button>
                </div>
                </div>

                <!-- Step 3: Demographics -->
                <div class="step" id="step-3">
                    <h2>⚧ Demographics</h2>
                    <label>
                        <span>Gender:</span>
                        <select name="gender" required>
                            <option value="" disabled selected>Select your gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </label>
                    <label>
                        <span>Birthday:</span>
                        <input type="date" name="bday" required />
                    </label>
                    <label>
                        <span>Photo:</span>
                        <input type="file" name="photo" accept="image/*" />
                    </label>
                    <div class="form-navigation">
                        <button type="button" class="fun-btn back-btn" onclick="prevStep()">⬅️ Back</button>
                    </div>
                </div> 
                <div class="form-navigation">
                    {{-- <button type="button" class="fun-btn back-btn" onclick="prevStep()">⬅️ Back</button> --}}
                    {{-- <button type="button" class="fun-btn next-btn" onclick="nextStep()">➡️ Next</button> --}}
                    <button type="submit" class="fun-btn submit-btn" style="display: block !important;">✅ Register</button>

                </div>
            </form>
            {{-- <form id="registration-form" action="{{ route('register_student') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <!-- Step 1: Personal Infoooooooooo -->
                <div class="step active" id="step-1">
                    <h2>👤 Personal Information</h2>
                    <label>
                        <span>Name:</span>
                        <input type="text" name="name" placeholder="Enter your name" required />
                    </label>
                    <label>
                        <span>Email:</span>
                        <input type="email" name="email" placeholder="Enter your email" required />
                    </label>
                    <label>
                        <span>Phone:</span>
                        <input type="tel" name="phone" placeholder="Enter your phone number" required />
                    </label>
                    <label>
                        <span>Password:</span>
                        <input type="password" name="password" placeholder="Create a password" required />
                    </label>
                </div>

                <!-- Step 2: Location -->
                <div class="step" id="step-2">
                    <h2>🌍 Location</h2>
                    <label>
                        <span>Country:</span>
                        <input type="text" name="country" placeholder="Enter your country" required />
                    </label>
                    <label>
                        <span>City:</span>
                        <input type="text" name="city" placeholder="Enter your city" required />
                    </label>
                    <label>
                        <span>School:</span>
                        <input type="text" name="school" placeholder="Enter your school" />
                    </label>
                </div>

                <!-- Step 3: Demographics -->
                <div class="step" id="step-3">
                    <h2>⚧ Demographics</h2>
                    <label>
                        <span>Gender:</span>
                        <select name="gender" required>
                            <option value="" disabled selected>Select your gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </label>
                    <label>
                        <span>Birthday:</span>
                        <input type="date" name="bday" required />
                    </label>
                    <label>
                        <span>Photo:</span>
                        <input type="file" name="photo" accept="image/*" />
                    </label>
                </div> --}}

                <!-- Step 4: Programming Knowledge -->
                {{-- <div class="step" id="step-4">
                    <h2>💻 Programming Knowledge</h2>
                    <h3>Do you know programming?</h3>
                    <div class="button-container">
                        <button type="button" class="fun-btn" onclick="showProgrammingLanguages()">Yes</button>
                        <button type="button" class="fun-btn" onclick="showCourseTrack()">No</button>
                    </div>
                </div>
                <section id="course-track">
                    <div class="content">
                        <img src="tracks/jr.png" alt="Junior Programming Track">
                        <div class="description">
                            <h3>🌟 <strong>Programming Universe Jr.</strong></h3>
                            <p>
                                Embark on a fun and exciting journey into the world of programming! This track is
                                perfect
                                for young learners who want to build their coding skills and creativity. Learn coding
                                basics through Scratch Jr. and Kodu Game Lab while fostering problem-solving and
                                collaboration
                                skills. Let's start your adventure today!
                            </p>
                        </div>
                    </div>
                </section>


                <!-- Step 5: Programming Languages -->
                <div class="step" id="step-5">
                    <h2>🌟 Programming Languages:</h2>
                    <h3>What programming languages do you know?</h3>
                    <div class="multi-select">
                        @foreach ($languages as $language)
                            <button class="fun-btn"
                                onclick="toggleSelection(this, '{{ $language->id }}', event)">{{ $language->name }}</button>
                        @endforeach
                    </div>
                    <div id="selected-programming-languages"></div>
                </div>


                <!-- Navigation Buttons -->
                <div class="form-navigation">
                    <button type="button" class="fun-btn back-btn" onclick="prevStep()">⬅️ Back</button>
                    <button type="button" class="fun-btn next-btn" onclick="nextStep()">➡️ Next</button>
                    <button type="submit" class="fun-btn submit-btn">✅ Submit</button>
                </div> --}}
            {{-- </form> --}}
        </div>
        <div id="popup">
            <div class="popup-content">
                <h2>🌟 Success!</h2>
                <p>Your adventure begins now. <strong>Happy Coding!</strong></p>
                <button class="close-btn" onclick="closePopup()">Close</button>
            </div>
        </div>
    </div>

    {{-- <script src="scripts.js"></script> --}}
</body>

</html>
