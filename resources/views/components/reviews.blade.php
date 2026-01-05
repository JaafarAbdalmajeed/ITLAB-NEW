@props(['track' => null, 'lesson' => null])

@php
    $reviewController = app(\App\Http\Controllers\ReviewController::class);
    if ($track) {
        $reviews = $reviewController->indexTrack(request(), $track);
    } else {
        $reviews = collect([]);
    }
    $rateableType = $track ? 'track' : 'lesson';
    $rateableId = $track ? $track->slug : $lesson->id;
@endphp

<div class="reviews-component" data-type="{{ $rateableType }}" data-id="{{ $rateableId }}">
    <div class="reviews-header">
        <h3 class="reviews-title">Reviews</h3>
        @auth
        <button class="btn-add-review" onclick="showReviewForm()">Write a Review</button>
        @else
        <a href="{{ route('auth.login') }}" class="btn-add-review">Login to Review</a>
        @endauth
    </div>

    @auth
    <div class="review-form-container" id="reviewForm" style="display: none;">
        <form class="review-form" onsubmit="submitReview(event, this)">
            <textarea name="review" placeholder="Write your review here..." required minlength="10" maxlength="1000" rows="4"></textarea>
            <div class="review-form-actions">
                <button type="submit" class="btn-submit-review">Submit Review</button>
                <button type="button" class="btn-cancel-review" onclick="hideReviewForm()">Cancel</button>
            </div>
        </form>
    </div>
    @endauth

    <div class="reviews-sort">
        <button class="sort-btn active" data-sort="helpful" onclick="sortReviews('helpful')">Most Helpful</button>
        <button class="sort-btn" data-sort="newest" onclick="sortReviews('newest')">Newest</button>
    </div>

    <div class="reviews-list" id="reviewsList">
        @forelse($reviews as $review)
            @php
                $hasVoted = auth()->check() ? $review->hasUserVoted(auth()->id()) : false;
                $userVote = $hasVoted && auth()->check()
                    ? $review->helpfulVotes()->where('user_id', auth()->id())->first()
                    : null;
            @endphp
            <div class="review-item">
                <div class="review-header">
                    <div class="review-user">
                        <div class="review-avatar">{{ strtoupper(substr($review->user->name, 0, 2)) }}</div>
                        <div class="review-user-info">
                            <div class="review-user-name">{{ $review->user->name }}</div>
                            <div class="review-date">{{ $review->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                    @if(auth()->check() && auth()->id() === $review->user_id)
                    <form method="POST" action="{{ route('reviews.destroy', $review) }}" onsubmit="return confirm('Are you sure?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete-review">Delete</button>
                    </form>
                    @endif
                </div>
                <div class="review-content">
                    {{ $review->review }}
                </div>
                <div class="review-footer">
                    <div class="review-helpful">
                        <span>Was this review helpful?</span>
                        <button class="btn-helpful {{ $userVote && $userVote->is_helpful ? 'active' : '' }}" 
                                onclick="voteReview({{ $review->id }}, true)"
                                {{ $hasVoted ? 'disabled' : '' }}>
                            👍 Yes ({{ $review->helpful_count }})
                        </button>
                        <button class="btn-helpful {{ $userVote && !$userVote->is_helpful ? 'active' : '' }}" 
                                onclick="voteReview({{ $review->id }}, false)"
                                {{ $hasVoted ? 'disabled' : '' }}>
                            👎 No ({{ $review->not_helpful_count }})
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="no-reviews">
                <p>No reviews yet. Be the first to review!</p>
            </div>
        @endforelse
    </div>
</div>

<style>
.reviews-component {
    background: radial-gradient(circle at top left, #111827, #020617);
    border: 1px solid #1f2937;
    border-radius: 18px;
    padding: 24px;
    margin: 24px 0;
}

.reviews-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.reviews-title {
    font-size: 20px;
    font-weight: 600;
    color: #fff;
}

.btn-add-review {
    padding: 10px 20px;
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    text-decoration: none;
    display: inline-block;
    transition: background 0.2s;
}

.btn-add-review:hover {
    background: #2563eb;
}

.review-form-container {
    margin-bottom: 24px;
    padding: 16px;
    background: rgba(59, 130, 246, 0.1);
    border-radius: 12px;
    border: 1px solid #3b82f6;
}

.review-form textarea {
    width: 100%;
    padding: 12px;
    background: #1f2937;
    border: 1px solid #374151;
    border-radius: 8px;
    color: #fff;
    font-size: 14px;
    font-family: inherit;
    resize: vertical;
}

.review-form-actions {
    display: flex;
    gap: 12px;
    margin-top: 12px;
}

.btn-submit-review {
    padding: 8px 16px;
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
}

.btn-cancel-review {
    padding: 8px 16px;
    background: transparent;
    color: #9ca3af;
    border: 1px solid #374151;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
}

.reviews-sort {
    display: flex;
    gap: 12px;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 1px solid #1f2937;
}

.sort-btn {
    padding: 6px 12px;
    background: transparent;
    color: #9ca3af;
    border: 1px solid #1f2937;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.2s;
}

.sort-btn:hover,
.sort-btn.active {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.review-item {
    padding: 20px;
    background: rgba(59, 130, 246, 0.05);
    border: 1px solid #1f2937;
    border-radius: 12px;
    margin-bottom: 16px;
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 12px;
}

.review-user {
    display: flex;
    align-items: center;
    gap: 12px;
}

.review-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    color: white;
}

.review-user-name {
    font-weight: 500;
    color: #fff;
}

.review-date {
    font-size: 12px;
    color: #9ca3af;
}

.review-content {
    color: #e5e7eb;
    line-height: 1.6;
    margin-bottom: 16px;
}

.review-footer {
    padding-top: 12px;
    border-top: 1px solid #1f2937;
}

.review-helpful {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
    color: #9ca3af;
}

.btn-helpful {
    padding: 4px 12px;
    background: transparent;
    color: #9ca3af;
    border: 1px solid #1f2937;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
    transition: all 0.2s;
}

.btn-helpful:hover:not(:disabled) {
    background: rgba(59, 130, 246, 0.1);
    border-color: #3b82f6;
    color: #3b82f6;
}

.btn-helpful.active {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

.btn-helpful:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-delete-review {
    padding: 4px 12px;
    background: transparent;
    color: #ef4444;
    border: 1px solid #ef4444;
    border-radius: 6px;
    cursor: pointer;
    font-size: 13px;
}

.no-reviews {
    text-align: center;
    padding: 40px;
    color: #9ca3af;
}
</style>

<script>
function showReviewForm() {
    document.getElementById('reviewForm').style.display = 'block';
}

function hideReviewForm() {
    document.getElementById('reviewForm').style.display = 'none';
    document.querySelector('.review-form textarea').value = '';
}

function submitReview(event, form) {
    event.preventDefault();
    const formData = new FormData(form);
    const component = form.closest('.reviews-component');
    const type = component.dataset.type;
    const id = component.dataset.id;
    
    const url = type === 'track' 
        ? `/tracks/${id}/reviews`
        : `/tracks/${id}/lessons/${id}/reviews`;
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if (!csrfToken) {
        alert('Error: CSRF token not found. Please refresh the page and try again.');
        return;
    }
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken.content,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(async response => {
        let data;
        try {
            data = await response.json();
        } catch (e) {
            throw new Error(`Server error: ${response.status} ${response.statusText}`);
        }
        
        if (!response.ok) {
            // Handle validation errors
            if (data.errors) {
                const errorMessages = Object.values(data.errors).flat().join('\n');
                throw new Error(errorMessages || data.message || 'Validation error');
            }
            throw new Error(data.message || `Server error: ${response.status}`);
        }
        return data;
    })
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message || 'Error submitting review');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(error.message || 'Error submitting review');
    });
}

function voteReview(reviewId, isHelpful) {
    fetch(`/reviews/${reviewId}/vote`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ is_helpful: isHelpful })
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

function sortReviews(sort) {
    document.querySelectorAll('.sort-btn').forEach(btn => {
        btn.classList.remove('active');
        if (btn.dataset.sort === sort) {
            btn.classList.add('active');
        }
    });
    
    const component = document.querySelector('.reviews-component');
    const type = component.dataset.type;
    const id = component.dataset.id;
    const url = `/tracks/${id}/reviews?sort=${sort}`;
    
    fetch(url, {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reload reviews list
            location.reload();
        }
    });
}
</script>

