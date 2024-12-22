<!-- resources/views/survey.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programming Survey</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
</head>
<body>
    <div id="app">
        <div class="floating-cloud cloud-1"></div>
        <div class="floating-star cloud-2"></div>
        <div class="floating-cloud cloud-3"></div>
        <div class="floating-star cloud-4"></div>

        <div id="registration-phase">

    <h2>💻 Programming Knowledge Survey</h2>
    <h3>Do you know programming?</h3>
    

    <form id="survey-form" action="{{ route('submit_survey', ['id' => $student->id]) }}" method="POST">
        @csrf
        <button type="button" class="fun-btn" onclick="showProgrammingLanguages()">Yes</button>
        <button type="button" class="fun-btn" onclick="showCourseTrack()">No</button>

        <!-- Step 4: Programming Knowledge -->
                <div class="step" id="step-4">
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
                </div>

        <button type="submit" class="fun-btn submit-btn">✅ Submit Survey</button>
    </form>
        </div>
        </div>
</body>
</html>
