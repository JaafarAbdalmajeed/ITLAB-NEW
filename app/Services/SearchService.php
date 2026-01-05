<?php

namespace App\Services;

use App\Models\Track;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Review;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SearchService
{
    /**
     * Perform advanced search across all content types
     */
    public function search(array $params): array
    {
        $query = $params['query'] ?? '';
        $category = $params['category'] ?? null;
        $level = $params['level'] ?? null;
        $type = $params['type'] ?? 'all'; // all, tracks, lessons, quizzes, reviews

        $results = [
            'tracks' => collect(),
            'lessons' => collect(),
            'quizzes' => collect(),
            'reviews' => collect(),
        ];

        // Search tracks
        if ($type === 'all' || $type === 'tracks') {
            $results['tracks'] = $this->searchTracks($query, $category, $level);
        }

        // Search lessons
        if ($type === 'all' || $type === 'lessons') {
            $results['lessons'] = $this->searchLessons($query, $category, $level);
        }

        // Search quizzes
        if ($type === 'all' || $type === 'quizzes') {
            $results['quizzes'] = $this->searchQuizzes($query, $category, $level);
        }

        // Search reviews
        if ($type === 'all' || $type === 'reviews') {
            $results['reviews'] = $this->searchReviews($query, $category);
        }

        // Calculate relevance scores and sort
        $this->calculateRelevance($results, $query);

        return $results;
    }

    /**
     * Search tracks
     */
    protected function searchTracks(string $query, ?string $category, ?string $level): Collection
    {
        $tracks = Track::query();

        // Apply search query
        if (!empty($query)) {
            $tracks->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('slug', 'like', "%{$query}%");
            });
        }

        // Filter by category
        if ($category) {
            $tracks->where('slug', 'like', "{$category}%");
        }

        // Filter by level (based on track completion rate or slug pattern)
        if ($level) {
            $tracks = $this->filterByLevel($tracks, $level);
        }

        return $tracks->withCount(['lessons', 'quizzes', 'userProgress'])
            ->get()
            ->map(function ($track) use ($query) {
                return [
                    'id' => $track->id,
                    'type' => 'track',
                    'title' => $track->title,
                    'description' => $track->description,
                    'slug' => $track->slug,
                    'url' => $this->getTrackUrl($track),
                    'lessons_count' => $track->lessons_count,
                    'quizzes_count' => $track->quizzes_count,
                    'students_count' => $track->user_progress_count,
                    'relevance_score' => 0,
                ];
            });
    }

    /**
     * Search lessons
     */
    protected function searchLessons(string $query, ?string $category, ?string $level): Collection
    {
        $lessons = Lesson::with('track');

        // Apply search query
        if (!empty($query)) {
            $lessons->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('content', 'like', "%{$query}%");
            });
        }

        // Filter by category (track category)
        if ($category) {
            $lessons->whereHas('track', function ($q) use ($category) {
                $q->where('slug', 'like', "{$category}%");
            });
        }

        // Filter by level (based on track level)
        if ($level) {
            $lessons->whereHas('track', function ($q) use ($level) {
                $this->filterByLevel($q, $level);
            });
        }

        return $lessons->get()
            ->map(function ($lesson) use ($query) {
                // Extract preview from content
                $preview = $this->extractPreview($lesson->content, $query, 150);
                
                return [
                    'id' => $lesson->id,
                    'type' => 'lesson',
                    'title' => $lesson->title,
                    'preview' => $preview,
                    'track' => [
                        'id' => $lesson->track->id,
                        'title' => $lesson->track->title,
                        'slug' => $lesson->track->slug,
                    ],
                    'url' => $this->getLessonUrl($lesson),
                    'relevance_score' => 0,
                ];
            });
    }

    /**
     * Search quizzes
     */
    protected function searchQuizzes(string $query, ?string $category, ?string $level): Collection
    {
        $quizzes = Quiz::with('track', 'questions');

        // Apply search query
        if (!empty($query)) {
            $quizzes->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhereHas('questions', function ($q) use ($query) {
                      $q->where('question', 'like', "%{$query}%");
                  });
            });
        }

        // Filter by category (track category)
        if ($category) {
            $quizzes->whereHas('track', function ($q) use ($category) {
                $q->where('slug', 'like', "{$category}%");
            });
        }

        // Filter by level (based on track level)
        if ($level) {
            $quizzes->whereHas('track', function ($q) use ($level) {
                $this->filterByLevel($q, $level);
            });
        }

        return $quizzes->withCount('questions')->get()
            ->map(function ($quiz) {
                return [
                    'id' => $quiz->id,
                    'type' => 'quiz',
                    'title' => $quiz->title,
                    'track' => [
                        'id' => $quiz->track->id,
                        'title' => $quiz->track->title,
                        'slug' => $quiz->track->slug,
                    ],
                    'questions_count' => $quiz->questions_count,
                    'url' => $this->getQuizUrl($quiz),
                    'relevance_score' => 0,
                ];
            });
    }

    /**
     * Search reviews
     */
    protected function searchReviews(string $query, ?string $category): Collection
    {
        $reviews = Review::with(['user', 'track', 'lesson'])
            ->where('is_approved', true);

        // Apply search query
        if (!empty($query)) {
            $reviews->where('review', 'like', "%{$query}%");
        }

        // Filter by category (track category)
        if ($category) {
            $reviews->whereHas('track', function ($q) use ($category) {
                $q->where('slug', 'like', "{$category}%");
            });
        }

        return $reviews->withCount(['helpfulVotes as helpful_count' => function ($q) {
            $q->where('is_helpful', true);
        }])->get()
            ->map(function ($review) use ($query) {
                $preview = $this->extractPreview($review->review, $query, 150);
                
                return [
                    'id' => $review->id,
                    'type' => 'review',
                    'review' => $preview,
                    'user' => [
                        'id' => $review->user->id,
                        'name' => $review->user->name,
                    ],
                    'track' => $review->track ? [
                        'id' => $review->track->id,
                        'title' => $review->track->title,
                        'slug' => $review->track->slug,
                    ] : null,
                    'lesson' => $review->lesson ? [
                        'id' => $review->lesson->id,
                        'title' => $review->lesson->title,
                    ] : null,
                    'helpful_count' => $review->helpful_count,
                    'url' => $this->getReviewUrl($review),
                    'relevance_score' => 0,
                ];
            });
    }

    /**
     * Filter tracks by level
     */
    protected function filterByLevel($query, string $level)
    {
        // Define level mappings based on track slugs or complexity
        switch ($level) {
            case 'beginner':
                // Beginner tracks: html, css
                return $query->whereIn('slug', ['html', 'css']);
            case 'intermediate':
                // Intermediate tracks: js, java
                return $query->whereIn('slug', ['js', 'java']);
            case 'advanced':
                // Advanced tracks: cyber-*
                return $query->where('slug', 'like', 'cyber%');
            default:
                return $query;
        }
    }

    /**
     * Calculate relevance scores for results
     */
    protected function calculateRelevance(array &$results, string $query): void
    {
        if (empty($query)) {
            return;
        }

        $queryLower = strtolower($query);
        $queryWords = explode(' ', $queryLower);

        foreach ($results as $type => $items) {
            $items->transform(function ($item) use ($queryLower, $queryWords, $type) {
                $score = 0;

                // Title match (highest weight)
                if (isset($item['title'])) {
                    $titleLower = strtolower($item['title']);
                    if (stripos($titleLower, $queryLower) !== false) {
                        $score += 100;
                    }
                    foreach ($queryWords as $word) {
                        if (stripos($titleLower, $word) !== false) {
                            $score += 20;
                        }
                    }
                }

                // Exact match bonus
                if (isset($item['title']) && strtolower($item['title']) === $queryLower) {
                    $score += 50;
                }

                // Description/content match
                if (isset($item['description'])) {
                    $descLower = strtolower($item['description']);
                    if (stripos($descLower, $queryLower) !== false) {
                        $score += 30;
                    }
                    foreach ($queryWords as $word) {
                        if (stripos($descLower, $word) !== false) {
                            $score += 10;
                        }
                    }
                }

                // Preview/content match for lessons and reviews
                if (isset($item['preview']) || isset($item['review'])) {
                    $content = strtolower($item['preview'] ?? $item['review']);
                    foreach ($queryWords as $word) {
                        $count = substr_count($content, $word);
                        $score += $count * 5;
                    }
                }

                // Slug match
                if (isset($item['slug'])) {
                    if (stripos(strtolower($item['slug']), $queryLower) !== false) {
                        $score += 15;
                    }
                }

                $item['relevance_score'] = $score;
                return $item;
            });

            // Sort by relevance score
            $results[$type] = $items->sortByDesc('relevance_score')->values();
        }
    }

    /**
     * Extract preview text from content
     */
    protected function extractPreview(string $content, string $query, int $length = 150): string
    {
        // Strip HTML tags
        $text = strip_tags($content);
        
        // Find query position
        $queryLower = strtolower($query);
        $textLower = strtolower($text);
        $pos = stripos($textLower, $queryLower);
        
        if ($pos !== false) {
            // Start from query position (with some context before)
            $start = max(0, $pos - 30);
            $preview = substr($text, $start, $length);
            if ($start > 0) {
                $preview = '...' . $preview;
            }
            if (strlen($text) > $start + $length) {
                $preview .= '...';
            }
            return $preview;
        }
        
        // Fallback to beginning
        return mb_substr($text, 0, $length) . (strlen($text) > $length ? '...' : '');
    }

    /**
     * Get track URL
     */
    protected function getTrackUrl(Track $track): string
    {
        return $track->getMainRoute();
    }

    /**
     * Get lesson URL
     */
    protected function getLessonUrl(Lesson $lesson): string
    {
        return route('tracks.lessons.show', ['track' => $lesson->track->slug, 'lesson' => $lesson->id]);
    }

    /**
     * Get quiz URL
     */
    protected function getQuizUrl(Quiz $quiz): string
    {
        return route('tracks.quizzes.show', ['track' => $quiz->track->slug, 'quiz' => $quiz->id]);
    }

    /**
     * Get review URL (link to track or lesson)
     */
    protected function getReviewUrl(Review $review): string
    {
        if ($review->track) {
            return $review->track->getMainRoute();
        }
        if ($review->lesson) {
            return route('tracks.lessons.show', ['track' => $review->lesson->track->slug, 'lesson' => $review->lesson->id]);
        }
        return '#';
    }

    /**
     * Get available categories
     */
    public function getCategories(): array
    {
        $categories = [
            'html' => 'HTML',
            'css' => 'CSS',
            'js' => 'JavaScript',
            'java' => 'Java',
            'cyber' => 'Cybersecurity',
        ];

        return $categories;
    }

    /**
     * Get available levels
     */
    public function getLevels(): array
    {
        return [
            'beginner' => 'Beginner',
            'intermediate' => 'Intermediate',
            'advanced' => 'Advanced',
        ];
    }
}

