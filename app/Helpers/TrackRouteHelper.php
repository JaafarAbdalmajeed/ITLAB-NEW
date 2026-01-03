<?php

namespace App\Helpers;

use App\Models\Track;
use Illuminate\Support\Facades\Route;

class TrackRouteHelper
{
    /**
     * Special tracks with custom routes (for backward compatibility)
     */
    private static function getSpecialTrackRoutes(): array
    {
        return [
            'html' => [
                'main' => 'pages.html',
                'track' => 'pages.html.track',
                'tutorial' => 'pages.html.tutorial',
                'reference' => 'pages.html.reference',
                'videos' => 'pages.html.videos',
                'labs' => 'pages.html.labs',
                'quiz' => 'pages.html.quiz',
            ],
            'css' => [
                'main' => 'pages.css',
                'track' => 'pages.css.track',
                'tutorial' => 'pages.css.tutorial',
                'reference' => 'pages.css.reference',
                'videos' => 'pages.css.videos',
                'labs' => 'pages.css.labs',
                'quiz' => 'pages.css.quiz',
            ],
            'js' => [
                'main' => 'pages.js',
                'track' => 'pages.js.track',
                'tutorial' => 'pages.js.tutorial',
                'reference' => 'pages.js.reference',
                'videos' => 'pages.js.videos',
                'labs' => 'pages.js.labs',
                'quiz' => 'pages.js.quiz',
            ],
            'java' => [
                'main' => 'pages.java',
                'track' => 'pages.java.track',
                'tutorial' => 'pages.java.tutorial',
                'reference' => 'pages.java.reference',
                'videos' => 'pages.java.videos',
                'labs' => 'pages.java.labs',
                'quiz' => 'pages.java.quiz',
            ],
            'cyber-network' => [
                'main' => 'pages.cyber-network',
                'track' => 'pages.cyber-network.track',
                'tutorial' => 'pages.cyber-network.tutorial',
                'reference' => 'pages.cyber-network.reference',
                'videos' => 'pages.cyber-network.videos',
                'labs' => 'pages.cyber-network.labs',
                'quiz' => 'pages.cyber-network.quiz',
            ],
            'cyber-web' => [
                'main' => 'pages.cyber-web',
                'track' => 'pages.cyber-web.track',
                'tutorial' => 'pages.cyber-web.tutorial',
                'reference' => 'pages.cyber-web.reference',
                'videos' => 'pages.cyber-web.videos',
                'labs' => 'pages.cyber-web.labs',
                'quiz' => 'pages.cyber-web.quiz',
            ],
        ];
    }

    /**
     * Get the main route for a track (dynamic for all tracks)
     */
    public static function getMainRoute(Track $track): string
    {
        $specialRoutes = self::getSpecialTrackRoutes();
        
        if (isset($specialRoutes[$track->slug])) {
            return route($specialRoutes[$track->slug]['main']);
        }
        
        // Dynamic route for any new track added from admin
        return route('pages.track.main', $track);
    }

    /**
     * Get the track/lessons route (dynamic for all tracks)
     */
    public static function getTrackRoute(Track $track): string
    {
        $specialRoutes = self::getSpecialTrackRoutes();
        
        if (isset($specialRoutes[$track->slug])) {
            return route($specialRoutes[$track->slug]['track']);
        }
        
        // Dynamic route for any new track added from admin
        return route('pages.track.lessons', $track);
    }

    /**
     * Get the tutorial route (dynamic for all tracks)
     */
    public static function getTutorialRoute(Track $track): string
    {
        $specialRoutes = self::getSpecialTrackRoutes();
        
        if (isset($specialRoutes[$track->slug])) {
            return route($specialRoutes[$track->slug]['tutorial']);
        }
        
        // Dynamic route for any new track added from admin
        return route('pages.track.tutorial', $track);
    }

    /**
     * Get the reference route (dynamic for all tracks)
     */
    public static function getReferenceRoute(Track $track): string
    {
        $specialRoutes = self::getSpecialTrackRoutes();
        
        if (isset($specialRoutes[$track->slug])) {
            return route($specialRoutes[$track->slug]['reference']);
        }
        
        // Dynamic route for any new track added from admin
        return route('pages.track.reference', $track);
    }

    /**
     * Get the videos route (dynamic for all tracks)
     */
    public static function getVideosRoute(Track $track): string
    {
        $specialRoutes = self::getSpecialTrackRoutes();
        
        if (isset($specialRoutes[$track->slug])) {
            return route($specialRoutes[$track->slug]['videos']);
        }
        
        // Dynamic route for any new track added from admin
        return route('pages.track.videos', $track);
    }

    /**
     * Get the labs route (dynamic for all tracks)
     */
    public static function getLabsRoute(Track $track): string
    {
        $specialRoutes = self::getSpecialTrackRoutes();
        
        if (isset($specialRoutes[$track->slug])) {
            return route($specialRoutes[$track->slug]['labs']);
        }
        
        // Dynamic route for any new track added from admin
        try {
            return route('pages.track.labs', $track);
        } catch (\Exception $e) {
            return $track->getMainRoute();
        }
    }

    /**
     * Get the quiz route (dynamic for all tracks)
     */
    public static function getQuizRoute(Track $track): string
    {
        $specialRoutes = self::getSpecialTrackRoutes();
        
        if (isset($specialRoutes[$track->slug])) {
            return route($specialRoutes[$track->slug]['quiz']);
        }
        
        // Dynamic route for any new track added from admin
        try {
            return route('pages.track.quiz', $track);
        } catch (\Exception $e) {
            return $track->getMainRoute();
        }
    }
}
