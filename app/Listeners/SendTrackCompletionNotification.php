<?php

namespace App\Listeners;

use App\Events\TrackCompleted;
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

        // Here you could send email notifications, award certificates, etc.
    }
}

