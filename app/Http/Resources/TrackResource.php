<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackResource extends JsonResource
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
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'lessons_count' => $this->whenLoaded('lessons', fn() => $this->lessons->count()),
            'quizzes_count' => $this->whenLoaded('quizzes', fn() => $this->quizzes->count()),
            'labs_count' => $this->whenLoaded('labs', fn() => $this->labs->count()),
            'lessons' => LessonResource::collection($this->whenLoaded('lessons')),
            'quizzes' => QuizResource::collection($this->whenLoaded('quizzes')),
            'labs' => LabResource::collection($this->whenLoaded('labs')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

