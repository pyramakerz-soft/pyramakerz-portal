<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Courses</title>
    <link rel="stylesheet" href="{{ asset('styles.css') }}">
    <style>
        body {
            font-family: 'Comic Sans MS', cursive;
            background: linear-gradient(135deg, #e0f7fa, #ffe0b2);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
        }

        .course-container {
            width: 90%;
            max-width: 1200px;
            margin: 2rem 0;
        }

        .course-card {
            background: #fff;
            border-radius: 15px;
            margin-bottom: 2rem;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .course-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .course-header h2 {
            color: #ff6347;
            margin: 0;
        }

        .course-paths {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .path-card {
            background: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            width: 30%;
            text-align: center;
            padding: 1rem;
            transition: transform 0.3s;
            position: relative;
        }

        .path-card.locked {
            opacity: 0.6;
            pointer-events: none;
        }

        .path-card:hover {
            transform: scale(1.05);
        }

        .path-card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
        }

        .path-card h3 {
            font-size: 1.2rem;
            margin: 1rem 0 0.5rem;
        }

        .path-card p {
            font-size: 0.9rem;
            color: #666;
        }

        .start-btn {
            display: block;
            margin: 1rem auto 0;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            background: linear-gradient(135deg, #4caf50, #8bc34a);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .start-btn:hover {
            background: linear-gradient(135deg, #388e3c, #4caf50);
        }

        .replay-btn {
            display: block;
            margin: 1rem auto 0;
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            background: linear-gradient(135deg, #fbc02d, #fdd835);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        .replay-btn:hover {
            background: linear-gradient(135deg, #f9a825, #fbc02d);
        }

        .logout-btn {
            margin-top: 2rem;
            padding: 1rem 2rem;
            font-size: 1.2rem;
            background: linear-gradient(135deg, #ff5722, #ff7043);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #e64a19, #ff5722);
        }
    </style>
</head>

<body>
    <h1>Welcome to Your Courses!</h1>
    <p>Explore your learning paths and continue your journey:</p>

    <div class="course-container">
        @forelse ($courses as $suggestion)
            <div class="course-card">
                <div class="course-header">
                    <h2>{{ $suggestion->course->name }}</h2>
                </div>
                <p>{{ $suggestion->course->description }}</p>
                <div class="course-paths">
                    @foreach ($suggestion->course->paths as $index => $path)
                        @php
                            $progress = $student
                                ->progress()
                                ->where('course_path_id', $path->id)
                                ->first();

                            $isCompleted =
                                $progress && $progress->progress_percentage == 100 && $progress->status == 'completed';

                            $previousPathProgress =
                                $index > 0
                                    ? $student
                                        ->progress()
                                        ->where('course_path_id', $suggestion->course->paths[$index - 1]->id)
                                        ->first()
                                    : null;

                            $previousPathCompleted =
                                $previousPathProgress && $previousPathProgress->progress_percentage == 100;

                            $isLocked = !$isCompleted && $index > 0 && !$previousPathCompleted;
                        @endphp

                        <div class="path-card {{ $isLocked ? 'locked' : '' }}">
                            <img src="{{ asset($path->image) }}" alt="{{ $path->name }}">
                            <h3>{{ $path->name }}</h3>
                            <p>{{ $path->description }}</p>
                            <p><strong>Duration:</strong> {{ $path->duration }} weeks</p>

                            @if ($isCompleted)
                                <p><span style="color: green;">✔️ Completed</span></p>
                                <button class="replay-btn">Replay Path</button>
                            @elseif (!$isLocked)
                                <button class="start-btn">Start Path</button>
                            @else
                                <p>Complete previous paths to unlock</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <p>No courses available for you at the moment. Please check back later!</p>
        @endforelse
    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="logout-btn">Logout</button>
    </form>
</body>

</html>
