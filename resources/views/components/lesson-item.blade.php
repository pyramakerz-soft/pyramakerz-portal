<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#lesson{{ $lesson->id }}"
            aria-expanded="false"
            aria-controls="lesson{{ $lesson->id }}">
            {{ $lesson->title }} 
            <span>Order: {{ $lesson->order ?? 'N/A' }}</span>
        </button>
    </h2>
    <div id="lesson{{ $lesson->id }}" class="accordion-collapse collapse" data-bs-parent="#{{ $parentId }}">
        <div class="accordion-body">
            <!-- Lesson Video -->
            <div class="video-container mb-3">
                @if ($lesson->video_url)
                    @php
                        $isGoogleDrive = str_contains($lesson->video_url, 'drive.google.com');
                        $embedUrl = $isGoogleDrive
                            ? preg_replace('/\/view\?usp=sharing$/', '/preview', $lesson->video_url)
                            : $lesson->video_url;
                    @endphp
                    <iframe src="{{ $embedUrl }}" width="100%" height="400" frameborder="0" allowfullscreen></iframe>
                @else
                    <p>No video available for this lesson.</p>
                @endif
            </div>
            <p><strong>Description:</strong> {{ $lesson->description ?? 'No description available.' }}</p>
            @if ($lesson->resource_file)
                <a href="{{ asset($lesson->resource_file) }}" download>Download Resource</a>
            @else
                <p>No resources available for this lesson.</p>
            @endif
        </div>
    </div>
</div>
