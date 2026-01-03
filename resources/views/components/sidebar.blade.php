@props([
    'currentTrack' => null,
    'currentPage' => null, // 'main', 'tutorial', 'reference', 'videos', 'labs', 'quiz', 'certified'
    'allTracks' => null,
    'certificationTracks' => null,
])

@php
    if (!$allTracks) {
        $allTracks = \App\Models\Track::with('lessons')->get();
    }
    
    // Determine if this is a track page or certification page
    $isCertificationPage = $currentPage === 'certified';
    $isTrackPage = $currentTrack !== null;
@endphp

<aside class="sidebar">
    <!-- Search -->
    <div class="sidebar-search">
        <input type="text" placeholder="Search..." id="sidebarSearch">
    </div>

    <!-- Topics -->
    <div class="sidebar-section">
        <div class="sidebar-section-title active" data-toggle="topics">
            <span>Topics</span>
            <i class="fa-solid fa-chevron-right" style="transform: rotate(90deg);"></i>
        </div>
        <div class="sidebar-section-content active" id="topicsContent">
            @foreach($allTracks as $track)
                <a href="{{ $track->getMainRoute() }}" class="sidebar-link {{ $isTrackPage && $currentTrack && $currentTrack->id === $track->id ? 'active' : '' }}">
                    {{ strtoupper($track->title) }}
                </a>
            @endforeach
        </div>
    </div>

    @if($isTrackPage && $currentTrack)
        <!-- Track Tutorial Section -->
        @if($currentTrack->show_tutorial ?? true)
        <div class="sidebar-section">
            <div class="sidebar-section-title {{ $currentPage === 'tutorial' ? 'active' : '' }}" data-toggle="tutorial">
                <span>{{ $currentTrack->title }} Tutorial</span>
                <i class="fa-solid fa-chevron-right" style="{{ $currentPage === 'tutorial' ? 'transform: rotate(90deg);' : '' }}"></i>
            </div>
            <div class="sidebar-section-content {{ $currentPage === 'tutorial' ? 'active' : '' }}" id="tutorialContent">
                <a href="{{ $currentTrack->getMainRoute() }}" class="sidebar-link {{ $currentPage === 'main' ? 'active' : '' }}">
                    {{ $currentTrack->title }} HOME
                </a>
                <a href="{{ $currentTrack->getMainRoute() }}" class="sidebar-link">
                    {{ $currentTrack->title }} Introduction
                </a>
                @if($currentTrack->lessons->count() > 0)
                    @foreach($currentTrack->lessons->take(10) as $lesson)
                        <a href="{{ $currentTrack->getTrackRoute() }}#lesson-{{ $lesson->id }}" class="sidebar-link">
                            {{ $lesson->title }}
                        </a>
                    @endforeach
                    @if($currentTrack->lessons->count() > 10)
                        <a href="{{ $currentTrack->getTrackRoute() }}" class="sidebar-link">
                            + {{ $currentTrack->lessons->count() - 10 }} more lessons
                        </a>
                    @endif
                @endif
            </div>
        </div>
        @endif

        <!-- Track Forms/Components -->
        @if($currentTrack->show_tutorial ?? true)
        <div class="sidebar-section">
            <div class="sidebar-section-title" data-toggle="forms">
                <span>{{ $currentTrack->title }} Forms</span>
                <i class="fa-solid fa-chevron-right"></i>
            </div>
            <div class="sidebar-section-content" id="formsContent">
                <a href="{{ $currentTrack->getTutorialRoute() }}" class="sidebar-link">
                    {{ $currentTrack->title }} Forms
                </a>
            </div>
        </div>
        @endif

        <!-- Track Examples -->
        <div class="sidebar-section">
            <div class="sidebar-section-title" data-toggle="examples">
                <span>Examples</span>
                <i class="fa-solid fa-chevron-right"></i>
            </div>
            <div class="sidebar-section-content" id="examplesContent">
                <a href="{{ $currentTrack->getMainRoute() }}" class="sidebar-link">{{ $currentTrack->title }} Examples</a>
                <a href="{{ route('pages.try-it') }}?type={{ $currentTrack->slug }}" class="sidebar-link">Try it Yourself</a>
            </div>
        </div>

        <!-- Track Exercises -->
        <div class="sidebar-section">
            <div class="sidebar-section-title" data-toggle="exercises">
                <span>Exercises</span>
                <i class="fa-solid fa-chevron-right"></i>
            </div>
            <div class="sidebar-section-content" id="exercisesContent">
                @if($currentTrack->show_labs ?? true)
                    <a href="{{ $currentTrack->getLabsRoute() }}" class="sidebar-link {{ $currentPage === 'labs' ? 'active' : '' }}">Labs</a>
                @endif
                @if($currentTrack->show_quiz ?? true)
                    <a href="{{ $currentTrack->getQuizRoute() }}" class="sidebar-link {{ $currentPage === 'quiz' ? 'active' : '' }}">Quiz</a>
                @endif
            </div>
        </div>

        <!-- Track Quiz Test -->
        @if($currentTrack->show_quiz ?? true)
        <div class="sidebar-section">
            <div class="sidebar-section-title {{ $currentPage === 'quiz' ? 'active' : '' }}" data-toggle="quiz">
                <span>Quiz Test</span>
                <i class="fa-solid fa-chevron-right" style="{{ $currentPage === 'quiz' ? 'transform: rotate(90deg);' : '' }}"></i>
            </div>
            <div class="sidebar-section-content {{ $currentPage === 'quiz' ? 'active' : '' }}" id="quizContent">
                <a href="{{ $currentTrack->getQuizRoute() }}" class="sidebar-link {{ $currentPage === 'quiz' ? 'active' : '' }}">{{ $currentTrack->title }} Quiz</a>
            </div>
        </div>
        @endif

        <!-- Track References -->
        @if($currentTrack->show_reference ?? true)
        <div class="sidebar-section">
            <div class="sidebar-section-title {{ $currentPage === 'reference' ? 'active' : '' }}" data-toggle="references">
                <span>References</span>
                <i class="fa-solid fa-chevron-right" style="{{ $currentPage === 'reference' ? 'transform: rotate(90deg);' : '' }}"></i>
            </div>
            <div class="sidebar-section-content {{ $currentPage === 'reference' ? 'active' : '' }}" id="referencesContent">
                <a href="{{ $currentTrack->getReferenceRoute() }}" class="sidebar-link {{ $currentPage === 'reference' ? 'active' : '' }}">{{ $currentTrack->title }} Reference</a>
                <a href="{{ $currentTrack->getTutorialRoute() }}" class="sidebar-link {{ $currentPage === 'tutorial' ? 'active' : '' }}">{{ $currentTrack->title }} Tutorial</a>
                @if($currentTrack->show_videos ?? true)
                    <a href="{{ $currentTrack->getVideosRoute() }}" class="sidebar-link {{ $currentPage === 'videos' ? 'active' : '' }}">{{ $currentTrack->title }} Videos</a>
                @endif
            </div>
        </div>
        @endif

        <!-- Certificate Section -->
        @auth
            @php
                $isCompleted = $currentTrack->isCompletedByUser(auth()->id());
                $certificate = $currentTrack->getUserCertificate(auth()->id());
            @endphp
            @if($isCompleted && $certificate)
            <div class="sidebar-section">
                <div class="sidebar-section-title {{ $currentPage === 'certificate' ? 'active' : '' }}" data-toggle="certificate">
                    <span>Certificate</span>
                    <i class="fa-solid fa-chevron-right" style="{{ $currentPage === 'certificate' ? 'transform: rotate(90deg);' : '' }}"></i>
                </div>
                <div class="sidebar-section-content {{ $currentPage === 'certificate' ? 'active' : '' }}" id="certificateContent">
                    <a href="{{ route('tracks.certificate.show', $currentTrack) }}" class="sidebar-link {{ $currentPage === 'certificate' ? 'active' : '' }}">
                        <i class="fas fa-certificate"></i> عرض الشهادة
                    </a>
                    <a href="{{ route('tracks.certificate.download', $currentTrack) }}" class="sidebar-link" target="_blank">
                        <i class="fas fa-download"></i> تحميل الشهادة
                    </a>
                </div>
            </div>
            @endif
        @endauth

    @elseif($isCertificationPage)
        <!-- Certification Tutorial -->
        <div class="sidebar-section">
            <div class="sidebar-section-title active" data-toggle="tutorial">
                <span>Certification Tutorial</span>
                <i class="fa-solid fa-chevron-right" style="transform: rotate(90deg);"></i>
            </div>
            <div class="sidebar-section-content active" id="tutorialContent">
                <a href="#home" class="sidebar-link active">Certification Home</a>
                <a href="#introduction" class="sidebar-link">Introduction</a>
                <a href="#how-to-get" class="sidebar-link">How to Get Certified</a>
                <a href="#requirements" class="sidebar-link">Requirements</a>
            </div>
        </div>

        <!-- Certification Process -->
        <div class="sidebar-section">
            <div class="sidebar-section-title" data-toggle="forms">
                <span>Certification Process</span>
                <i class="fa-solid fa-chevron-right"></i>
            </div>
            <div class="sidebar-section-content" id="formsContent">
                <a href="#take-quiz" class="sidebar-link">Take Quiz</a>
                <a href="#view-syllabus" class="sidebar-link">View Syllabus</a>
                <a href="#download-cert" class="sidebar-link">Download Certificate</a>
            </div>
        </div>

        <!-- Examples -->
        <div class="sidebar-section">
            <div class="sidebar-section-title" data-toggle="examples">
                <span>Examples</span>
                <i class="fa-solid fa-chevron-right"></i>
            </div>
            <div class="sidebar-section-content" id="examplesContent">
                <a href="#cert-examples" class="sidebar-link">Certificate Examples</a>
                <a href="#track-examples" class="sidebar-link">Track Examples</a>
            </div>
        </div>

        <!-- Exercises -->
        <div class="sidebar-section">
            <div class="sidebar-section-title" data-toggle="exercises">
                <span>Exercises</span>
                <i class="fa-solid fa-chevron-right"></i>
            </div>
            <div class="sidebar-section-content" id="exercisesContent">
                <a href="#practice-quiz" class="sidebar-link">Practice Quiz</a>
                <a href="#cert-exam" class="sidebar-link">Certification Exam</a>
            </div>
        </div>

        <!-- Quiz Test -->
        @if($certificationTracks && $certificationTracks->count() > 0)
        <div class="sidebar-section">
            <div class="sidebar-section-title" data-toggle="quiz">
                <span>Quiz Test</span>
                <i class="fa-solid fa-chevron-right"></i>
            </div>
            <div class="sidebar-section-content" id="quizContent">
                @foreach($certificationTracks->take(5) as $track)
                    <a href="{{ $track->getQuizRoute() }}" class="sidebar-link">{{ $track->title }} Quiz</a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- References -->
        <div class="sidebar-section">
            <div class="sidebar-section-title" data-toggle="references">
                <span>References</span>
                <i class="fa-solid fa-chevron-right"></i>
            </div>
            <div class="sidebar-section-content" id="referencesContent">
                <a href="#cert-list" class="sidebar-link">Certificate List</a>
                <a href="#track-list" class="sidebar-link">Track List</a>
                <a href="#faq" class="sidebar-link">FAQ</a>
            </div>
        </div>
    @endif
</aside>

