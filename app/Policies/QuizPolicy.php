<?php

namespace App\Policies;

use App\Models\Quiz;
use App\Models\User;

class QuizPolicy
{
    /**
     * Determine if the user can view any quizzes.
     */
    public function viewAny(?User $user): bool
    {
        return true; // Allow anyone to view quizzes list
    }

    /**
     * Determine if the user can view the quiz.
     */
    public function view(?User $user, Quiz $quiz): bool
    {
        return true; // Allow anyone to view quizzes
    }
    
    /**
     * Determine if the user can view quiz results.
     */
    public function viewResults(?User $user, Quiz $quiz): bool
    {
        return true; // Allow anyone to view quiz results (they'll be redirected to login if needed)
    }

    /**
     * Determine if the user can create quizzes.
     */
    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine if the user can update the quiz.
     */
    public function update(User $user, Quiz $quiz): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine if the user can delete the quiz.
     */
    public function delete(User $user, Quiz $quiz): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine if the user can submit the quiz.
     */
    public function submit(?User $user, Quiz $quiz): bool
    {
        return $user !== null; // User must be logged in to submit
    }
}

