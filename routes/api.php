<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizResultController;
use App\Http\Controllers\UserProgressController;
use App\Http\Resources\TrackResource;
use App\Models\Track;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['throttle:api'])->group(function () {
    // Public routes
    Route::get('/tracks', function () {
        return TrackResource::collection(Track::with(['lessons', 'quizzes', 'labs'])->get());
    });

    Route::get('/tracks/{track}', function (Track $track) {
        $track->load(['lessons', 'quizzes.questions', 'labs']);
        return new TrackResource($track);
    });

    // Protected routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        // Quiz results
        Route::get('/tracks/{track}/quizzes/{quiz}/results', [QuizResultController::class, 'index']);
        Route::post('/tracks/{track}/quizzes/{quiz}/results', [QuizResultController::class, 'store']);

        // User progress
        Route::get('/tracks/{track}/progress', [UserProgressController::class, 'show']);
        Route::post('/tracks/{track}/progress', [UserProgressController::class, 'update']);
        Route::get('/progress/overall', [UserProgressController::class, 'overall']);
    });
});

