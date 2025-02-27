<!DOCTYPE html>
<html class="no-js " lang="zxx">

<head>
    @include('include.head')

</head>
<body class="body__wrapper">
    @include('include.load')

    @include('include.nav')
    <style>
        .rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            font-size: 2rem;
            cursor: pointer;
        }
    
        .rating input {
            display: none;
        }
    
        .rating label {
            color: #ddd;
            transition: color 0.3s;
        }
    
        .rating input:checked ~ label {
            color: gold;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.8);
        }
    
        .rating label:hover,
        .rating label:hover ~ label {
            color: gold;
        }
    </style>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0 text-center">📊 Session Evaluation</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('meetings.evaluate.submit', $meeting->id) }}" method="POST">
                            @csrf
    
                            <!-- Session Information -->
                            <div class="mb-3">
                                <strong>📚 Session:</strong> {{ $meeting->topic }} <br>
                                <strong>👨‍🏫 Instructor:</strong> {{ $meeting->group->instructor->name }} <br>
                                <strong>📅 Date:</strong> {{ \Carbon\Carbon::parse($meeting->start_time)->format('M d, Y') }} <br>
                            </div>
    
                            <hr>
    
                            <!-- Ratings Section -->
                            <h5 class="text-primary">Rate the Session and Instructor</h5>
    
                            <!-- Content Quality -->
                            <div class="mb-3">
                                <label class="form-label">📖 Content Quality</label>
                                <div class="rating">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="content_quality" value="{{ $i }}" id="content-{{ $i }}" required>
                                        <label for="content-{{ $i }}">★</label>
                                    @endfor
                                </div>
                            </div>
    
                            <!-- Instructor Clarity -->
                            <div class="mb-3">
                                <label class="form-label">🗣️ Instructor's Clarity</label>
                                <div class="rating">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="instructor_clarity" value="{{ $i }}" id="clarity-{{ $i }}" required>
                                        <label for="clarity-{{ $i }}">★</label>
                                    @endfor
                                </div>
                            </div>
    
                            <!-- Engagement -->
                            <div class="mb-3">
                                <label class="form-label">🎭 Student Engagement</label>
                                <div class="rating">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="engagement" value="{{ $i }}" id="engagement-{{ $i }}" required>
                                        <label for="engagement-{{ $i }}">★</label>
                                    @endfor
                                </div>
                            </div>
    
                            <!-- Pace of the session -->
                            <div class="mb-3">
                                <label class="form-label">⏳ Pace of the Session</label>
                                <div class="rating">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="pace" value="{{ $i }}" id="pace-{{ $i }}" required>
                                        <label for="pace-{{ $i }}">★</label>
                                    @endfor
                                </div>
                            </div>
    
                            <!-- Technology and tools -->
                            <div class="mb-3">
                                <label class="form-label">🖥️ Technology & Tools Used</label>
                                <div class="rating">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="technology_usage" value="{{ $i }}" id="tech-{{ $i }}" required>
                                        <label for="tech-{{ $i }}">★</label>
                                    @endfor
                                </div>
                            </div>
    
                            <!-- Overall Experience -->
                            <div class="mb-3">
                                <label class="form-label">🌟 Overall Experience</label>
                                <div class="rating">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <input type="radio" name="overall_experience" value="{{ $i }}" id="overall-{{ $i }}" required>
                                        <label for="overall-{{ $i }}">★</label>
                                    @endfor
                                </div>
                            </div>
    
                            <!-- Feedback -->
                            <div class="mb-3">
                                <label class="form-label">✍️ Additional Feedback (Optional)</label>
                                <textarea name="feedback" class="form-control" rows="3" placeholder="Share your thoughts..."></textarea>
                            </div>
    
                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-success px-5">Submit Evaluation ✅</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('include.footer')
    @include('include.scripts')
</body>
</html>