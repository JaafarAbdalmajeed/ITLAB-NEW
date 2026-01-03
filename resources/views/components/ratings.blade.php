@props(['track' => null, 'lesson' => null])

@php
    $ratingController = app(\App\Http\Controllers\RatingController::class);
    if ($track) {
        $ratingData = $ratingController->showTrack($track);
    } else {
        $ratingData = ['average' => 0, 'count' => 0, 'user_rating' => null, 'distribution' => []];
    }
    $userRating = $ratingData['user_rating'] ?? null;
    $averageRating = $ratingData['average'] ?? 0;
    $ratingCount = $ratingData['count'] ?? 0;
    $distribution = $ratingData['distribution'] ?? [];
    $rateableType = $track ? 'track' : 'lesson';
    $rateableId = $track ? $track->id : $lesson->id;
@endphp

<div class="ratings-component" data-type="{{ $rateableType }}" data-id="{{ $rateableId }}">
    <div class="ratings-header">
        <div class="ratings-summary">
            <div class="rating-stars-large">
                @for($i = 1; $i <= 5; $i++)
                    <span class="star {{ $i <= round($averageRating) ? 'filled' : '' }}">
                        @if($i <= round($averageRating))
                            ★
                        @else
                            ☆
                        @endif
                    </span>
                @endfor
            </div>
            <div class="rating-info">
                <div class="rating-average">{{ number_format($averageRating, 1) }}</div>
                <div class="rating-count">{{ $ratingCount }} {{ $ratingCount === 1 ? 'rating' : 'ratings' }}</div>
            </div>
        </div>
        
        @auth
        <div class="rating-form-container">
            <div class="rating-form-title">Rate this {{ $rateableType }}</div>
            <form class="rating-form" onsubmit="submitRating(event, this)">
                <div class="star-rating-input">
                    @for($i = 5; $i >= 1; $i--)
                        <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" {{ $userRating == $i ? 'checked' : '' }}>
                        <label for="star{{ $i }}" class="star-label">★</label>
                    @endfor
                </div>
                <button type="submit" class="btn-submit-rating">Submit Rating</button>
            </form>
        </div>
        @else
        <div class="login-prompt">
            <a href="{{ route('auth.login') }}">Login to rate</a>
        </div>
        @endauth
    </div>

    @if(!empty($distribution))
    <div class="rating-distribution">
        <div class="distribution-title">Rating Distribution</div>
        @for($i = 5; $i >= 1; $i--)
            @php
                $dist = $distribution[$i] ?? ['count' => 0, 'percentage' => 0];
            @endphp
            <div class="distribution-row">
                <span class="distribution-label">{{ $i }}★</span>
                <div class="distribution-bar">
                    <div class="distribution-fill" style="width: {{ $dist['percentage'] }}%"></div>
                </div>
                <span class="distribution-value">{{ $dist['count'] }}</span>
            </div>
        @endfor
    </div>
    @endif
</div>

<style>
.ratings-component {
    background: radial-gradient(circle at top left, #111827, #020617);
    border: 1px solid #1f2937;
    border-radius: 18px;
    padding: 24px;
    margin: 24px 0;
}

.ratings-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 32px;
    margin-bottom: 24px;
}

.ratings-summary {
    display: flex;
    align-items: center;
    gap: 16px;
}

.rating-stars-large {
    font-size: 32px;
    color: #fbbf24;
    letter-spacing: 4px;
}

.rating-stars-large .star.filled {
    color: #fbbf24;
}

.rating-info {
    display: flex;
    flex-direction: column;
}

.rating-average {
    font-size: 32px;
    font-weight: 600;
    color: #fff;
}

.rating-count {
    font-size: 14px;
    color: #9ca3af;
}

.rating-form-container {
    flex: 1;
    max-width: 300px;
}

.rating-form-title {
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 12px;
    color: #9ca3af;
}

.star-rating-input {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    gap: 4px;
    margin-bottom: 12px;
}

.star-rating-input input[type="radio"] {
    display: none;
}

.star-rating-input label {
    font-size: 28px;
    color: #374151;
    cursor: pointer;
    transition: color 0.2s;
}

.star-rating-input input[type="radio"]:checked ~ label,
.star-rating-input label:hover,
.star-rating-input label:hover ~ label {
    color: #fbbf24;
}

.btn-submit-rating {
    padding: 8px 16px;
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: background 0.2s;
}

.btn-submit-rating:hover {
    background: #2563eb;
}

.rating-distribution {
    margin-top: 24px;
    padding-top: 24px;
    border-top: 1px solid #1f2937;
}

.distribution-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 12px;
    color: #9ca3af;
}

.distribution-row {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 8px;
}

.distribution-label {
    font-size: 14px;
    color: #9ca3af;
    width: 40px;
}

.distribution-bar {
    flex: 1;
    height: 8px;
    background: #1f2937;
    border-radius: 4px;
    overflow: hidden;
}

.distribution-fill {
    height: 100%;
    background: linear-gradient(90deg, #3b82f6, #8b5cf6);
    transition: width 0.3s;
}

.distribution-value {
    font-size: 14px;
    color: #9ca3af;
    width: 40px;
    text-align: right;
}

.login-prompt {
    text-align: center;
    padding: 16px;
}

.login-prompt a {
    color: #3b82f6;
    text-decoration: none;
}

@media (max-width: 768px) {
    .ratings-header {
        flex-direction: column;
    }
    
    .rating-form-container {
        max-width: 100%;
    }
}
</style>

<script>
function submitRating(event, form) {
    event.preventDefault();
    const formData = new FormData(form);
    const rating = formData.get('rating');
    const component = form.closest('.ratings-component');
    const type = component.dataset.type;
    const id = component.dataset.id;
    
    const url = type === 'track' 
        ? `/tracks/${id}/ratings`
        : `/tracks/${id}/lessons/${id}/ratings`;
    
    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ rating: parseInt(rating) })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
</script>

