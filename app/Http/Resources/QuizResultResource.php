<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuizResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'score' => $this->score,
            'user_id' => $this->user_id,
            'quiz_id' => $this->quiz_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'quiz' => new QuizResource($this->whenLoaded('quiz')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

