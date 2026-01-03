<?php

namespace App\Listeners;

use App\Events\TrackCompleted;
use App\Models\Certificate;
use Illuminate\Support\Facades\Log;

class SendTrackCompletionNotification
{
    /**
     * Handle the event.
     */
    public function handle(TrackCompleted $event): void
    {
        $user = $event->user;
        $track = $event->track;

        Log::info("Track completed: User {$user->id} completed track {$track->id}");

        // Automatically create certificate when track is completed
        Certificate::firstOrCreate(
            [
                'user_id' => $user->id,
                'track_id' => $track->id,
            ],
            [
                'certificate_number' => Certificate::generateCertificateNumber(),
                'issued_at' => now(),
            ]
        );

        Log::info("Certificate created for user {$user->id}, track {$track->id}");

        // Clear leaderboard cache for tracks and certificates
        try {
            $leaderboardService = app(\App\Services\LeaderboardService::class);
            $leaderboardService->clearCache('tracks');
            $leaderboardService->clearCache('certificates');
        } catch (\Exception $e) {
            // Ignore if LeaderboardService is not available
        }
    }
}

