<?php

namespace App\Helpers;

use App\Models\Track;
use Illuminate\Support\Facades\Route;

class TrackRouteHelper
{
    /**
     * Get the main route for a track
     */
    public static function getMainRoute(Track $track): string
    {
        return match($track->slug) {
            'html' => route('pages.html'),
            'css' => route('pages.css'), // Uses /learn-css route
            'js' => route('pages.js'), // Uses /learn-js route
            'cyber-network' => route('pages.cyber-network'),
            'cyber-web' => route('pages.cyber-web'),
            default => route('tracks.show', $track),
        };
    }

    /**
     * Get the track/lessons route
     */
    public static function getTrackRoute(Track $track): string
    {
        return match($track->slug) {
            'html' => route('pages.html.track'),
            'css' => route('pages.css.track'),
            'js' => route('pages.js.track'),
            default => route('tracks.show', $track),
        };
    }

    /**
     * Get the tutorial route
     */
    public static function getTutorialRoute(Track $track): string
    {
        return match($track->slug) {
            'html' => route('pages.html.tutorial'),
            'css' => route('pages.css.tutorial'),
            'js' => route('pages.js.tutorial'),
            'cyber-network' => route('pages.cyber-network.tutorial'),
            'cyber-web' => route('pages.cyber-web.tutorial'),
            default => $track->getMainRoute(), // Use main route as fallback
        };
    }

    /**
     * Get the reference route
     */
    public static function getReferenceRoute(Track $track): string
    {
        return match($track->slug) {
            'html' => route('pages.html.reference'),
            'css' => route('pages.css.reference'),
            'js' => route('pages.js.reference'),
            'cyber-network' => route('pages.cyber-network.reference'),
            'cyber-web' => route('pages.cyber-web.reference'),
            default => $track->getMainRoute(), // Use main route as fallback
        };
    }

    /**
     * Get the videos route
     */
    public static function getVideosRoute(Track $track): string
    {
        return match($track->slug) {
            'html' => route('pages.html.videos'),
            'css' => route('pages.css.videos'),
            'js' => route('pages.js.videos'),
            'cyber-network' => route('pages.cyber-network.videos'),
            'cyber-web' => route('pages.cyber-web.videos'),
            default => $track->getMainRoute(), // Use main route as fallback
        };
    }

    /**
     * Get the labs route
     */
    public static function getLabsRoute(Track $track): string
    {
        return match($track->slug) {
            'html' => route('pages.html.labs'),
            'css' => route('pages.css.labs'),
            'js' => route('pages.js.labs'),
            'cyber-network' => route('pages.cyber-network.labs'),
            'cyber-web' => route('pages.cyber-web.labs'),
            default => route('tracks.labs.index', $track), // Use general route for other tracks
        };
    }

    /**
     * Get the quiz route
     */
    public static function getQuizRoute(Track $track): string
    {
        return match($track->slug) {
            'html' => route('pages.html.quiz'),
            'css' => route('pages.css.quiz'),
            'js' => route('pages.js.quiz'),
            'cyber-network' => route('pages.cyber-network.quiz'),
            'cyber-web' => route('pages.cyber-web.quiz'),
            default => route('tracks.quizzes.index', $track), // Use general route for other tracks
        };
    }
}

