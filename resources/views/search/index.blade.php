@extends('layouts.app')

@section('title', 'Advanced Search — ITLAB')
@section('body-class', 'page-search')

@section('content')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
<style>
  .page-wrapper {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
  }
  
  .search-header {
    margin-bottom: 40px;
  }
  
  .search-header h1 {
    font-size: 32px;
    margin-bottom: 12px;
  }
  
  .search-form {
    background: #fff;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    margin-bottom: 32px;
  }
  
  .search-input-group {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
  }
  
  .search-input {
    flex: 1;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 16px;
    transition: border-color 0.3s;
  }
  
  .search-input:focus {
    outline: none;
    border-color: #04aa6d;
  }
  
  .search-btn {
    padding: 12px 32px;
    background: #04aa6d;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s;
  }
  
  .search-btn:hover {
    background: #059862;
  }
  
  .filters {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
  }
  
  .filter-group {
    display: flex;
    flex-direction: column;
  }
  
  .filter-group label {
    font-weight: 600;
    margin-bottom: 8px;
    color: #374151;
  }
  
  .filter-group select {
    padding: 10px 12px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    background: #fff;
    cursor: pointer;
    transition: border-color 0.3s;
  }
  
  .filter-group select:focus {
    outline: none;
    border-color: #04aa6d;
  }
  
  .results-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 2px solid #e5e7eb;
  }
  
  .results-count {
    font-size: 18px;
    font-weight: 600;
    color: #374151;
  }
  
  .results-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
  }
  
  .results-tab {
    padding: 8px 16px;
    background: #f3f4f6;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s;
  }
  
  .results-tab.active {
    background: #04aa6d;
    color: #fff;
  }
  
  .results-tab:hover {
    background: #059862;
    color: #fff;
  }
  
  .results-section {
    margin-bottom: 40px;
  }
  
  .results-section-title {
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 20px;
    color: #111827;
    display: flex;
    align-items: center;
    gap: 12px;
  }
  
  .results-section-title i {
    color: #04aa6d;
  }
  
  .results-list {
    display: grid;
    gap: 16px;
  }
  
  .result-item {
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-left: 4px solid #04aa6d;
    transition: transform 0.2s, box-shadow 0.2s;
  }
  
  .result-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  }
  
  .result-item-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 12px;
  }
  
  .result-item-title {
    font-size: 20px;
    font-weight: 600;
    color: #111827;
    margin: 0;
  }
  
  .result-item-title a {
    color: #111827;
    text-decoration: none;
    transition: color 0.2s;
  }
  
  .result-item-title a:hover {
    color: #04aa6d;
  }
  
  .result-item-type {
    padding: 4px 12px;
    background: #f3f4f6;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    color: #6b7280;
    text-transform: uppercase;
  }
  
  .result-item-type.track { background: #dbeafe; color: #1e40af; }
  .result-item-type.lesson { background: #fef3c7; color: #92400e; }
  .result-item-type.quiz { background: #e9d5ff; color: #6b21a8; }
  .result-item-type.review { background: #d1fae5; color: #065f46; }
  
  .result-item-description {
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 12px;
  }
  
  .result-item-meta {
    display: flex;
    gap: 16px;
    font-size: 14px;
    color: #9ca3af;
    flex-wrap: wrap;
  }
  
  .result-item-meta span {
    display: flex;
    align-items: center;
    gap: 6px;
  }
  
  .result-item-meta i {
    color: #04aa6d;
  }
  
  .no-results {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  }
  
  .no-results i {
    font-size: 64px;
    color: #d1d5db;
    margin-bottom: 20px;
  }
  
  .no-results h3 {
    font-size: 24px;
    color: #374151;
    margin-bottom: 12px;
  }
  
  .no-results p {
    color: #6b7280;
    font-size: 16px;
  }
  
  .highlight {
    background: #fef3c7;
    padding: 2px 4px;
    border-radius: 4px;
    font-weight: 600;
  }
  
  @media (max-width: 768px) {
    .search-input-group {
      flex-direction: column;
    }
    
    .filters {
      grid-template-columns: 1fr;
    }
    
    .results-header {
      flex-direction: column;
      align-items: flex-start;
      gap: 16px;
    }
    
    .results-tabs {
      width: 100%;
    }
  }
  
  body.theme-dark .search-form,
  body.theme-dark .result-item,
  body.theme-dark .no-results {
    background: #2a2a2a;
    color: #e0e0e0;
  }
  
  body.theme-dark .filter-group label,
  body.theme-dark .result-item-title,
  body.theme-dark .results-section-title,
  body.theme-dark .results-count {
    color: #e0e0e0;
  }
  
  body.theme-dark .search-input,
  body.theme-dark .filter-group select {
    background: #1a1a1a;
    border-color: #404040;
    color: #e0e0e0;
  }
  
  body.theme-dark .result-item-description {
    color: #b0b0b0;
  }
</style>
@endpush

<main class="page-wrapper">
  <header class="search-header">
    <h1>🔍 Advanced Search</h1>
    <p style="color:#9ca3af; max-width:720px;">
      Search across all content: tracks, lessons, quizzes, and reviews. Use filters to narrow down your search results.
    </p>
  </header>

  <form method="GET" action="{{ route('search.index') }}" class="search-form">
    <div class="search-input-group">
      <input 
        type="text" 
        name="q" 
        value="{{ $query }}"
        placeholder="Search by keywords..." 
        class="search-input"
        autofocus
      >
      <button type="submit" class="search-btn">
        <i class="fas fa-search"></i> Search
      </button>
    </div>
    
    <div class="filters">
      <div class="filter-group">
        <label for="type">Content Type</label>
        <select name="type" id="type">
          <option value="all" {{ $type === 'all' ? 'selected' : '' }}>All</option>
          <option value="tracks" {{ $type === 'tracks' ? 'selected' : '' }}>Tracks</option>
          <option value="lessons" {{ $type === 'lessons' ? 'selected' : '' }}>Lessons</option>
          <option value="quizzes" {{ $type === 'quizzes' ? 'selected' : '' }}>Quizzes</option>
          <option value="reviews" {{ $type === 'reviews' ? 'selected' : '' }}>Reviews</option>
        </select>
      </div>
      
      <div class="filter-group">
        <label for="category">Category</label>
        <select name="category" id="category">
          <option value="">All</option>
          @foreach($categories as $key => $label)
            <option value="{{ $key }}" {{ $category === $key ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
      </div>
      
      <div class="filter-group">
        <label for="level">Level</label>
        <select name="level" id="level">
          <option value="">All</option>
          @foreach($levels as $key => $label)
            <option value="{{ $key }}" {{ $level === $key ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </form>

  @if(!empty($query) || $category || $level)
    <div class="results-header">
      <div class="results-count">
        @if($totalResults > 0)
          Found {{ $totalResults }} result(s)
        @else
          No results found
        @endif
      </div>
    </div>

    @if($totalResults > 0)
      <!-- Tracks Results -->
      @if($results['tracks']->count() > 0 && ($type === 'all' || $type === 'tracks'))
        <div class="results-section">
          <h2 class="results-section-title">
            <i class="fas fa-road"></i>
            Tracks ({{ $results['tracks']->count() }})
          </h2>
          <div class="results-list">
            @foreach($results['tracks'] as $track)
              <div class="result-item">
                <div class="result-item-header">
                  <h3 class="result-item-title">
                    <a href="{{ $track['url'] }}">{{ $track['title'] }}</a>
                  </h3>
                  <span class="result-item-type track">Track</span>
                </div>
                @if($track['description'])
                  <p class="result-item-description">{{ $track['description'] }}</p>
                @endif
                <div class="result-item-meta">
                  <span><i class="fas fa-book"></i> {{ $track['lessons_count'] }} lessons</span>
                  <span><i class="fas fa-question-circle"></i> {{ $track['quizzes_count'] }} quizzes</span>
                  <span><i class="fas fa-users"></i> {{ $track['students_count'] }} students</span>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      <!-- Lessons Results -->
      @if($results['lessons']->count() > 0 && ($type === 'all' || $type === 'lessons'))
        <div class="results-section">
          <h2 class="results-section-title">
            <i class="fas fa-book-open"></i>
            Lessons ({{ $results['lessons']->count() }})
          </h2>
          <div class="results-list">
            @foreach($results['lessons'] as $lesson)
              <div class="result-item">
                <div class="result-item-header">
                  <h3 class="result-item-title">
                    <a href="{{ $lesson['url'] }}">{{ $lesson['title'] }}</a>
                  </h3>
                  <span class="result-item-type lesson">Lesson</span>
                </div>
                @if(isset($lesson['preview']))
                  <p class="result-item-description">{{ $lesson['preview'] }}</p>
                @endif
                <div class="result-item-meta">
                  <span><i class="fas fa-road"></i> {{ $lesson['track']['title'] }}</span>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      <!-- Quizzes Results -->
      @if($results['quizzes']->count() > 0 && ($type === 'all' || $type === 'quizzes'))
        <div class="results-section">
          <h2 class="results-section-title">
            <i class="fas fa-question-circle"></i>
            Quizzes ({{ $results['quizzes']->count() }})
          </h2>
          <div class="results-list">
            @foreach($results['quizzes'] as $quiz)
              <div class="result-item">
                <div class="result-item-header">
                  <h3 class="result-item-title">
                    <a href="{{ $quiz['url'] }}">{{ $quiz['title'] }}</a>
                  </h3>
                  <span class="result-item-type quiz">Quiz</span>
                </div>
                <div class="result-item-meta">
                  <span><i class="fas fa-road"></i> {{ $quiz['track']['title'] }}</span>
                  <span><i class="fas fa-list"></i> {{ $quiz['questions_count'] }} questions</span>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif

      <!-- Reviews Results -->
      @if($results['reviews']->count() > 0 && ($type === 'all' || $type === 'reviews'))
        <div class="results-section">
          <h2 class="results-section-title">
            <i class="fas fa-comments"></i>
            Reviews ({{ $results['reviews']->count() }})
          </h2>
          <div class="results-list">
            @foreach($results['reviews'] as $review)
              <div class="result-item">
                <div class="result-item-header">
                  <h3 class="result-item-title">
                    <a href="{{ $review['url'] }}">
                      Review by {{ $review['user']['name'] }}
                    </a>
                  </h3>
                  <span class="result-item-type review">Review</span>
                </div>
                @if(isset($review['review']))
                  <p class="result-item-description">{{ $review['review'] }}</p>
                @endif
                <div class="result-item-meta">
                  @if($review['track'])
                    <span><i class="fas fa-road"></i> {{ $review['track']['title'] }}</span>
                  @endif
                  @if($review['lesson'])
                    <span><i class="fas fa-book-open"></i> {{ $review['lesson']['title'] }}</span>
                  @endif
                  @if($review['helpful_count'] > 0)
                    <span><i class="fas fa-thumbs-up"></i> {{ $review['helpful_count'] }} helpful</span>
                  @endif
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    @else
      <div class="no-results">
        <i class="fas fa-search"></i>
        <h3>No results found</h3>
        <p>Try changing your search terms or removing some filters</p>
      </div>
    @endif
  @else
    <div class="no-results">
      <i class="fas fa-search"></i>
      <h3>Start Searching</h3>
      <p>Enter search keywords or use filters to find the content you're looking for</p>
    </div>
  @endif
</main>

@push('scripts')
<script>
  // Auto-submit form when filters change
  document.querySelectorAll('select[name="type"], select[name="category"], select[name="level"]').forEach(select => {
    select.addEventListener('change', function() {
      if (document.querySelector('input[name="q"]').value || this.value) {
        this.form.submit();
      }
    });
  });
</script>
@endpush
@endsection

